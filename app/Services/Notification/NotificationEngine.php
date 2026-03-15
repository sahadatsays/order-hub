<?php

namespace App\Services\Notification;

use App\Models\Notification;
use App\Models\NotificationLog;
use App\Models\NotificationRule;
use App\Models\NotificationTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationEngine
{
    public function __construct(
        private TemplateRenderer $renderer,
        private RecipientResolver $resolver,
    ) {}

    /**
     * Process a business event and dispatch notifications based on matching rules.
     */
    public function handle(string $event, array $context): array
    {
        $tenantId = $context['tenant_id'] ?? null;
        if (!$tenantId) {
            return [];
        }

        $rules = NotificationRule::forTenant($tenantId)
            ->forEvent($event)
            ->active()
            ->get();

        $notifications = [];

        foreach ($rules as $rule) {
            if (!$rule->evaluateConditions($context)) {
                continue;
            }

            $recipients = $this->resolver->resolve($rule->targets ?? [], $context);

            foreach ($rule->channels as $channel) {
                $template = $this->findTemplate($tenantId, $event, $channel);

                foreach ($recipients as $recipient) {
                    $notification = $this->createNotification(
                        $tenantId, $rule, $event, $channel, $recipient, $template, $context
                    );

                    if ($notification) {
                        $notifications[] = $notification;
                    }
                }
            }
        }

        return $notifications;
    }

    private function findTemplate(int $tenantId, string $event, string $channel): ?NotificationTemplate
    {
        return NotificationTemplate::forTenant($tenantId)
            ->forEvent($event)
            ->forChannel($channel)
            ->active()
            ->orderByDesc('tenant_id')
            ->first();
    }

    private function createNotification(
        int $tenantId,
        NotificationRule $rule,
        string $event,
        string $channel,
        array $recipient,
        ?NotificationTemplate $template,
        array $context
    ): ?Notification {
        $idempotencyKey = $this->generateIdempotencyKey(
            $tenantId, $event, $channel, $recipient, $context
        );

        if (Notification::where('idempotency_key', $idempotencyKey)->exists()) {
            return null;
        }

        $rendered = $this->renderContent($template, $channel, $event, $context);

        return DB::transaction(function () use (
            $tenantId, $rule, $event, $channel, $recipient, $rendered, $idempotencyKey, $context
        ) {
            return Notification::create([
                'tenant_id'         => $tenantId,
                'rule_id'           => $rule->id,
                'event'             => $event,
                'channel'           => $channel,
                'recipient_type'    => $recipient['type'],
                'recipient_id'      => $recipient['id'] ?? null,
                'recipient_contact' => $channel === 'email'
                    ? ($recipient['email'] ?? null)
                    : ($channel === 'sms' ? ($recipient['phone'] ?? null) : null),
                'subject'           => $rendered['subject'],
                'body'              => $rendered['body'],
                'status'            => 'pending',
                'related_type'      => $context['related_type'] ?? null,
                'related_id'        => $context['related_id'] ?? null,
                'idempotency_key'   => $idempotencyKey,
                'scheduled_at'      => $rule->delay_seconds > 0
                    ? now()->addSeconds($rule->delay_seconds)
                    : null,
            ]);
        });
    }

    private function renderContent(
        ?NotificationTemplate $template,
        string $channel,
        string $event,
        array $context
    ): array {
        if ($template) {
            return $this->renderer->renderTemplate([
                'subject' => $template->subject,
                'body'    => $template->body,
            ], $context);
        }

        $eventLabel = NotificationTemplate::EVENTS[$event] ?? $event;

        return [
            'subject' => $eventLabel,
            'body'    => "Notification: {$eventLabel}",
        ];
    }

    private function generateIdempotencyKey(
        int $tenantId,
        string $event,
        string $channel,
        array $recipient,
        array $context
    ): string {
        $recipientKey = ($recipient['type'] ?? '') . ':' . ($recipient['id'] ?? $recipient['email'] ?? $recipient['phone'] ?? '');
        $relatedKey = ($context['related_type'] ?? '') . ':' . ($context['related_id'] ?? '');
        $statusKey = $context['new_status'] ?? $context['order_status'] ?? '';

        return md5(implode('|', [$tenantId, $event, $channel, $recipientKey, $relatedKey, $statusKey]));
    }
}
