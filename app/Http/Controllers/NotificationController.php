<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationLog;
use App\Models\NotificationRule;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $tid = $this->tenantId();

        $query = Notification::where('tenant_id', $tid)
            ->orderByDesc('created_at');

        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        $notifications = $query->paginate(25);

        $unreadCount = Notification::where('tenant_id', $tid)
            ->where('channel', 'database')
            ->whereNull('read_at')
            ->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function show(Notification $notification): View
    {
        abort_unless($notification->tenant_id === $this->tenantId(), 403);

        $logs = $notification->logs()->get();

        return view('notifications.show', compact('notification', 'logs'));
    }

    public function markAsRead(Notification $notification)
    {
        abort_unless($notification->tenant_id === $this->tenantId(), 403);

        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead()
    {
        $tid = $this->tenantId();
        $userId = auth()->id();

        Notification::where('tenant_id', $tid)
            ->where('channel', 'database')
            ->where('recipient_type', 'user')
            ->where('recipient_id', $userId)
            ->whereNull('read_at')
            ->update([
                'status'  => 'read',
                'read_at' => now(),
            ]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function rules(): View
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $rules = NotificationRule::where('tenant_id', $this->tenantId())
            ->orderByDesc('created_at')
            ->paginate(25);

        $events = NotificationTemplate::EVENTS;

        return view('notifications.rules', compact('rules', 'events'));
    }

    public function storeRule(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'event'         => 'required|string',
            'channels'      => 'required|array|min:1',
            'channels.*'    => 'in:database,email,sms',
            'targets'       => 'required|array|min:1',
            'targets.*'     => 'in:customer,assigned_staff,admins,owner',
            'conditions'    => 'nullable|array',
            'delay_seconds' => 'nullable|integer|min:0',
        ]);

        $validated['tenant_id'] = $this->tenantId();
        $validated['delay_seconds'] = $validated['delay_seconds'] ?? 0;

        NotificationRule::create($validated);

        return redirect()->route('notifications.rules')
            ->with('success', 'Notification rule created.');
    }

    public function toggleRule(NotificationRule $rule)
    {
        abort_unless($rule->tenant_id === $this->tenantId(), 403);
        abort_unless(auth()->user()->isAdmin(), 403);

        $rule->update(['is_active' => !$rule->is_active]);

        $status = $rule->is_active ? 'enabled' : 'disabled';

        return redirect()->route('notifications.rules')
            ->with('success', "Rule {$status}.");
    }

    public function destroyRule(NotificationRule $rule)
    {
        abort_unless($rule->tenant_id === $this->tenantId(), 403);
        abort_unless(auth()->user()->isAdmin(), 403);

        $rule->delete();

        return redirect()->route('notifications.rules')
            ->with('success', 'Rule deleted.');
    }

    public function templates(): View
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $templates = NotificationTemplate::forTenant($this->tenantId())
            ->orderByDesc('created_at')
            ->paginate(25);

        $events = NotificationTemplate::EVENTS;
        $channels = NotificationTemplate::CHANNELS;

        return view('notifications.templates', compact('templates', 'events', 'channels'));
    }

    public function storeTemplate(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'event'   => 'required|string',
            'channel' => 'required|in:database,email,sms',
            'subject' => 'nullable|string|max:255',
            'body'    => 'required|string',
        ]);

        $validated['tenant_id'] = $this->tenantId();

        NotificationTemplate::create($validated);

        return redirect()->route('notifications.templates')
            ->with('success', 'Template created.');
    }

    public function destroyTemplate(NotificationTemplate $template)
    {
        abort_unless(!$template->is_system, 403, 'Cannot delete system templates.');
        abort_unless(
            $template->tenant_id === $this->tenantId() || $template->is_system,
            403
        );
        abort_unless(auth()->user()->isAdmin(), 403);

        $template->delete();

        return redirect()->route('notifications.templates')
            ->with('success', 'Template deleted.');
    }

    public function logs(): View
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $logs = NotificationLog::where('tenant_id', $this->tenantId())
            ->with('notification')
            ->orderByDesc('attempted_at')
            ->paginate(25);

        return view('notifications.logs', compact('logs'));
    }

    public function retry(Notification $notification)
    {
        abort_unless($notification->tenant_id === $this->tenantId(), 403);
        abort_unless(auth()->user()->isAdmin(), 403);

        if ($notification->status !== 'failed') {
            return redirect()->back()->with('error', 'Only failed notifications can be retried.');
        }

        $notification->update(['status' => 'pending']);

        if ($notification->channel === 'email') {
            \App\Jobs\SendEmailNotificationJob::dispatch($notification->id);
        } elseif ($notification->channel === 'sms') {
            \App\Jobs\SendSmsNotificationJob::dispatch($notification->id);
        } else {
            $notification->markAsSent();
        }

        return redirect()->back()->with('success', 'Notification retry queued.');
    }
}
