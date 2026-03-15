<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * AJAX: Search active products by name or SKU.
     */
    public function search(Request $request): JsonResponse
    {
        $tid = $this->tenantId();
        $q = $request->get('q', '');

        $products = Product::where('tenant_id', $tid)
            ->where('is_active', true)
            ->when($q, fn ($query) => $query->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%");
            }))
            ->limit(15)
            ->get(['id', 'name', 'sku', 'price']);

        return response()->json($products);
    }

    public function index(Request $request): View
    {
        $tid = $this->tenantId();

        $products = Product::where('tenant_id', $tid)
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('sku', 'like', "%{$request->search}%");
            }))
            ->when($request->category, fn ($q) => $q->where('category', $request->category))
            ->when($request->status, fn ($q) => $q->where('is_active', $request->status === 'active'))
            ->with('inventoryItem')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $categories = Product::where('tenant_id', $tid)->select('category')->distinct()->pluck('category')->filter()->values();

        $stats = [
            'total' => Product::where('tenant_id', $tid)->count(),
            'active' => Product::where('tenant_id', $tid)->where('is_active', true)->count(),
            'low_stock' => 0,
            'out_of_stock' => 0,
        ];

        return view('products.index', compact('products', 'categories', 'stats'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:5000',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'track_inventory' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['track_inventory'] = $request->boolean('track_inventory', true);

        $product = Product::create(array_merge($validated, [
            'tenant_id' => auth()->user()->tenant_id,
        ]));

        return redirect()->route('products.show', $product)
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $product->load('inventoryItem');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:5000',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'track_inventory' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['track_inventory'] = $request->boolean('track_inventory');

        $product->update($validated);

        return redirect()->route('products.show', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted.');
    }
}
