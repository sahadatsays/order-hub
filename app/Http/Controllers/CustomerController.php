<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = Customer::query()
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('phone', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            }))
            ->when($request->source, fn ($q) => $q->where('source', $request->source))
            ->withCount('orders')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total'        => Customer::count(),
            'this_month'   => Customer::whereMonth('created_at', now()->month)->count(),
            'repeat'       => Customer::where('orders_count', '>', 1)->count(),
        ];

        return view('customers.index', compact('customers', 'stats'));
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:30',
            'address'     => 'nullable|string|max:500',
            'city'        => 'nullable|string|max:100',
            'state'       => 'nullable|string|max:100',
            'country'     => 'nullable|string|max:2',
            'postal_code' => 'nullable|string|max:20',
            'source'      => 'nullable|string|max:50',
            'notes'       => 'nullable|string|max:2000',
        ]);

        $customer = Customer::create(array_merge($validated, [
            'tenant_id' => auth()->user()->tenant_id,
        ]));

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer): View
    {
        $customer->load(['orders' => fn ($q) => $q->orderByDesc('ordered_at')->limit(10)]);

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:30',
            'address'     => 'nullable|string|max:500',
            'city'        => 'nullable|string|max:100',
            'state'       => 'nullable|string|max:100',
            'country'     => 'nullable|string|max:2',
            'postal_code' => 'nullable|string|max:20',
            'source'      => 'nullable|string|max:50',
            'notes'       => 'nullable|string|max:2000',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted.');
    }
}
