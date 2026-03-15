<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Order;
use App\Models\OrderStatusLog;
use InvalidArgumentException;

class OrderStatusService
{
    /**
     * Allowed status transitions.
     * Each key maps to the statuses it can transition to.
     */
    const TRANSITIONS = [
        'pending'    => ['confirmed', 'processing', 'cancelled', 'on_hold'],
        'confirmed'  => ['processing', 'packed', 'cancelled', 'on_hold'],
        'processing' => ['packed', 'shipped', 'cancelled', 'on_hold'],
        'packed'     => ['shipped', 'cancelled', 'on_hold'],
        'shipped'    => ['delivered', 'on_hold'],
        'delivered'  => ['refunded', 'returned'],
        'cancelled'  => [],
        'refunded'   => [],
        'on_hold'    => ['pending', 'confirmed', 'processing', 'cancelled'],
        'returned'   => [],
    ];

    /**
     * Statuses that allow order editing.
     */
    const EDITABLE_STATUSES = ['pending', 'confirmed', 'on_hold'];

    /**
     * Statuses that represent terminal states.
     */
    const TERMINAL_STATUSES = ['cancelled', 'refunded', 'returned'];

    /**
     * Check if a status transition is allowed.
     */
    public function canTransition(string $from, string $to): bool
    {
        $allowed = self::TRANSITIONS[$from] ?? [];
        return in_array($to, $allowed, true);
    }

    /**
     * Get allowed next statuses for a given status.
     */
    public function allowedTransitions(string $currentStatus): array
    {
        return self::TRANSITIONS[$currentStatus] ?? [];
    }

    /**
     * Check if an order can be edited in its current status.
     */
    public function canEdit(Order $order): bool
    {
        return in_array($order->status, self::EDITABLE_STATUSES, true);
    }

    /**
     * Transition an order to a new status with validation.
     *
     * @throws InvalidArgumentException
     */
    public function transition(Order $order, string $newStatus, ?int $userId = null, ?string $note = null): Order
    {
        $oldStatus = $order->status;

        if ($oldStatus === $newStatus) {
            return $order;
        }

        if (! $this->canTransition($oldStatus, $newStatus)) {
            throw new InvalidArgumentException(
                "Cannot transition from '{$oldStatus}' to '{$newStatus}'."
            );
        }

        // Cancellation check: don't allow if order is fully paid unless forcing
        if ($newStatus === 'cancelled' && $order->paid_amount > 0) {
            throw new InvalidArgumentException(
                'Cannot cancel an order with existing payments. Refund payments first.'
            );
        }

        $order->update(['status' => $newStatus]);

        OrderStatusLog::log(
            orderId: $order->id,
            changedBy: $userId,
            fromStatus: $oldStatus,
            toStatus: $newStatus,
            note: $note
        );

        AuditLog::record(
            tenantId: $order->tenant_id,
            userId: $userId,
            auditableType: Order::class,
            auditableId: $order->id,
            event: 'status_changed',
            field: 'status',
            oldValue: $oldStatus,
            newValue: $newStatus
        );

        return $order;
    }
}
