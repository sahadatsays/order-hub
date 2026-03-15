<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Order;
use App\Models\OrderPayment;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class OrderPaymentService
{
    public function __construct(
        protected OrderCalculationService $calculationService
    ) {}

    /**
     * Record a payment against an order.
     *
     * @throws InvalidArgumentException
     */
    public function recordPayment(
        Order  $order,
        string $method,
        float  $amount,
        ?int   $collectedBy = null,
        ?float $tendered = null,
        ?string $reference = null,
        ?string $note = null
    ): OrderPayment {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Payment amount must be greater than zero.');
        }

        $dueAmount = $this->calculationService->dueAmount(
            (float) $order->total_amount,
            (float) $order->paid_amount
        );

        if ($amount > $dueAmount && $method !== 'cash') {
            throw new InvalidArgumentException(
                "Payment amount ({$amount}) exceeds due amount ({$dueAmount})."
            );
        }

        // For cash, calculate change
        $changeAmount = 0;
        if ($method === 'cash' && $tendered !== null && $tendered > $amount) {
            $changeAmount = round($tendered - $amount, 2);
        }

        // Cap payment at due amount
        $effectiveAmount = min($amount, $dueAmount);

        return DB::transaction(function () use ($order, $method, $effectiveAmount, $collectedBy, $tendered, $changeAmount, $reference, $note) {
            $payment = OrderPayment::create([
                'order_id'      => $order->id,
                'collected_by'  => $collectedBy,
                'method'        => $method,
                'amount'        => $effectiveAmount,
                'tendered'      => $tendered,
                'change_amount' => $changeAmount,
                'reference'     => $reference,
                'note'          => $note,
            ]);

            $newPaid = round((float) $order->paid_amount + $effectiveAmount, 2);

            $paymentStatus = $this->calculationService->derivePaymentStatus(
                $newPaid,
                (float) $order->total_amount
            );

            $order->update([
                'paid_amount'    => $newPaid,
                'payment_status' => $paymentStatus,
                'payment_method' => $method,
            ]);

            AuditLog::record(
                tenantId: $order->tenant_id,
                userId: $collectedBy,
                auditableType: Order::class,
                auditableId: $order->id,
                event: 'payment_recorded',
                field: 'paid_amount',
                oldValue: $order->getOriginal('paid_amount'),
                newValue: $newPaid,
                metadata: [
                    'method'    => $method,
                    'amount'    => $effectiveAmount,
                    'reference' => $reference,
                ]
            );

            return $payment;
        });
    }

    /**
     * Get total paid amount from payment records.
     */
    public function totalPaid(Order $order): float
    {
        return (float) $order->payments()->sum('amount');
    }
}
