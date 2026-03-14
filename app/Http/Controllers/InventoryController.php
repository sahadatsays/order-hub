<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        $tid = $this->tenantId();

        $items = InventoryItem::where('tenant_id', $tid)
            ->with('product')
            ->when($request->search, fn ($q) => $q->whereHas('product', fn ($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('sku', 'like', "%{$request->search}%")))
            ->when($request->filter === 'low_stock', fn ($q) => $q->whereColumn('quantity_on_hand', '<=', 'reorder_point'))
            ->when($request->filter === 'out_of_stock', fn ($q) => $q->where('quantity_on_hand', '<=', 0))
            ->orderByDesc('updated_at')
            ->paginate(25)
            ->withQueryString();

        $stats = [
            'total_products' => Product::where('tenant_id', $tid)->count(),
            'low_stock'      => InventoryItem::where('tenant_id', $tid)->whereColumn('quantity_on_hand', '<=', 'reorder_point')->where('quantity_on_hand', '>', 0)->count(),
            'out_of_stock'   => InventoryItem::where('tenant_id', $tid)->where('quantity_on_hand', '<=', 0)->count(),
            'total_value'    => InventoryItem::where('inventory_items.tenant_id', $tid)
                ->join('products', 'products.id', '=', 'inventory_items.product_id')
                ->selectRaw('SUM(inventory_items.quantity_on_hand * products.cost_price) as value')
                ->value('value') ?? 0,
        ];

        return view('inventory.index', compact('items', 'stats'));
    }

    public function update(Request $request, InventoryItem $inventoryItem)
    {
        $validated = $request->validate([
            'quantity_on_hand' => 'required|integer|min:0',
            'reorder_point'    => 'nullable|integer|min:0',
            'reorder_quantity' => 'nullable|integer|min:0',
            'location'         => 'nullable|string|max:100',
        ]);

        $inventoryItem->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory updated.');
    }
}
