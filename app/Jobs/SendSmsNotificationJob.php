<?php

namespace App\Jobs;

use App\Contracts\SmsProviderInterface;
use App\Models\Notification;
use App\Models\NotificationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public array $backoff = [60, 120, 300];

    public function __construct(
        public readonly int $notificationId,
    ) {}

    public function handle(): void
    {
        $notification = Notification::find($this->notificationId);

        if (!$notification || $notification->status === 'sent') {
            return;
        }

        $phone = $notification->recipient_contact;
        if (!$phone || !preg_match('/^\+?[0-9]{7,15}$/', preg_replace('/\s+/', '', $phone))) {
            $notification->markAsFailed();
            NotificationLog::record(
                $notification->id,
                $notification->tenant_id,
                'sms',
                'failed',
                null,
                null,
                null,
                'Invalid or missing phone number',
                $this->attempts()
            );

            return;
        }

        if (!app()->bound(SmsProviderInterface::class)) {
            $notification->markAsFailed();
            NotificationLog::record(
                $notification->id,
                $notification->tenant_id,
                'sms',
                'failed',
                null,
                null,
                null,
                'No SMS provider configured',
                $this->attempts()
            );

            return;
        }

        $provider = app(SmsProviderInterface::class);

        try {
            $result = $provider->send($phone, $notification->body);

            $status = $result['success'] ? 'sent' : 'failed';

            NotificationLog::record(
                $notification->id,
                $notification->tenant_id,
                'sms',
                $status,
                $provider->providerName(),
                ['to' => $phone, 'body' => $notification->body],
                $result['provider_response'] ?? null,
                $result['success'] ? null : ($result['message'] ?? 'SMS send failed'),
                $this->attempts()
            );

            if ($result['success']) {
                $notification->markAsSent();
            } elseif ($this->attempts() >= $this->tries) {
                $notification->markAsFailed();
            }
        } catch (\Throwable $e) {
            NotificationLog::record(
                $notification->id,
                $notification->tenant_id,
                'sms',
                'failed',
                $provider->providerName(),
                ['to' => $phone],
                null,
                $e->getMessage(),
                $this->attempts()
            );

            if ($this->attempts() >= $this->tries) {
                $notification->markAsFailed();
            }

            throw $e;
        }
    }

    public function uniqueId(): string
    {
        return 'sms-notification-' . $this->notificationId;
    }
}
