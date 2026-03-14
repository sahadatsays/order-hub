<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $invoices = Invoice::with(['order'])
            ->when($request->search, fn ($q) => $q->where('invoice_number', 'like', "%{$request->search}%")
                ->orWhereHas('order', fn ($q) => $q->where('customer_name', 'like', "%{$request->search}%")))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('issued_at')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total'   => Invoice::count(),
            'paid'    => Invoice::where('status', 'paid')->count(),
            'pending' => Invoice::whereIn('status', ['draft', 'sent'])->count(),
            'overdue' => Invoice::where('status', 'sent')
                ->whereNotNull('due_at')
                ->where('due_at', '<', now())
                ->count(),
        ];

        return view('invoices.index', compact('invoices', 'stats'));
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load(['order.items', 'order.customer']);

        return view('invoices.show', compact('invoice'));
    }

    public function print(Invoice $invoice): View
    {
        $invoice->load(['order.items', 'order.customer']);

        return view('invoices.print', compact('invoice'));
    }
}
