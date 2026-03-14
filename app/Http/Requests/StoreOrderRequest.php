<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id'              => 'nullable|exists:customers,id',
            'source'                   => 'required|in:' . implode(',', array_keys(Order::SOURCES)),
            'customer_name'            => 'required|string|max:255',
            'customer_phone'           => 'nullable|string|max:30',
            'customer_email'           => 'nullable|email|max:255',
            'shipping_address'         => 'nullable|string|max:500',
            'shipping_city'            => 'nullable|string|max:100',
            'payment_method'           => 'nullable|string|max:100',
            'payment_status'           => 'required|in:unpaid,partial,paid',
            'discount_amount'          => 'nullable|numeric|min:0',
            'discount_code'            => 'nullable|string|max:50',
            'shipping_charge'          => 'nullable|numeric|min:0',
            'paid_amount'              => 'nullable|numeric|min:0',
            'notes'                    => 'nullable|string|max:2000',
            'internal_notes'           => 'nullable|string|max:2000',
            'items'                    => 'required|array|min:1',
            'items.*.product_id'       => 'nullable|exists:products,id',
            'items.*.product_name'     => 'required|string|max:255',
            'items.*.product_sku'      => 'nullable|string|max:100',
            'items.*.variant'          => 'nullable|string|max:255',
            'items.*.quantity'         => 'required|integer|min:1',
            'items.*.unit_price'       => 'required|numeric|min:0',
            'items.*.discount_amount'  => 'nullable|numeric|min:0',
        ];
    }
}
