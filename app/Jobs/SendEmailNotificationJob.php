<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\NotificationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationJob implements ShouldQueue
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

        $email = $notification->recipient_contact;
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $notification->markAsFailed();
            NotificationLog::record(
                $notification->id,
                $notification->tenant_id,
                'email',
                'failed',
                'smtp',
                null,
                null,
                'Invalid or missing email address',
                $this->attempts()
            );

            return;
        }

        try {
            Mail::raw($notification->body, function ($message) use ($notification, $email) {
                $message->to($email)
                    ->subject($notification->subject ?? 'Notification');
            });

            $notification->markAsSent();
            NotificationLog::record(
                $notification->id,
                $notification->tenant_id,
                'email',
                'sent',
                'smtp',
                ['to' => $email, 'subject' => $notification->subject],
                null,
                null,
                $this->attempts()
            );
        } catch (\Throwable $e) {
            NotificationLog::record(
                $notification->id,
                $notification->tenant_id,
                'email',
                'failed',
                'smtp',
                ['to' => $email, 'subject' => $notification->subject],
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
        return 'email-notification-' . $this->notificationId;
    }
}
