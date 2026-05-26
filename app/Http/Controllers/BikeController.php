<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BikeController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $category = $request->input('category');
        $status   = $request->input('status');

        $bikes = Bike::when($search, fn($q) =>
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('brand', 'like', "%$search%")
                      ->orWhere('sku', 'like', "%$search%")
                )
                ->when($category, fn($q) => $q->where('category', $category))
                ->when($status,   fn($q) => $q->where('status', $status))
                ->orderBy('name')
                ->paginate(12);

        $categories  = Bike::categories();
        $totalBikes  = Bike::count();
        $lowStock    = Bike::whereColumn('stock', '<=', 'stock_min')->count();
        $totalValue  = Bike::sum(\DB::raw('sale_price * stock'));

        return view('bikes', compact(
            'bikes', 'categories', 'search', 'category', 'status',
            'totalBikes', 'lowStock', 'totalValue'
        ));
    }

    public function create()
    {
        $categories = Bike::categories();
        return view('create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'required|string|max:255',
            'model'       => 'nullable|string|max:255',
            'category'    => 'required|in:' . implode(',', array_keys(Bike::categories())),
            'description' => 'nullable|string',
            'cost_price'  => 'required|numeric|min:0',
            'sale_price'  => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'stock_min'   => 'required|integer|min:0',
            'sku'         => 'nullable|string|max:100|unique:bikes,sku',
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('bikes', 'public');
        }

        Bike::create($data);

        return redirect()->route('bikes.index')
                         ->with('success', 'Produto "' . $data['name'] . '" cadastrado com sucesso!');
    }

    public function show(Bike $bike)
    {
        return view('show', compact('bike'));
    }

    public function edit(Bike $bike)
    {
        $categories = Bike::categories();
        return view('edit', compact('bike', 'categories'));
    }

    public function update(Request $request, Bike $bike)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'required|string|max:255',
            'model'       => 'nullable|string|max:255',
            'category'    => 'required|in:' . implode(',', array_keys(Bike::categories())),
            'description' => 'nullable|string',
            'cost_price'  => 'required|numeric|min:0',
            'sale_price'  => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'stock_min'   => 'required|integer|min:0',
            'sku'         => 'nullable|string|max:100|unique:bikes,sku,' . $bike->id,
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Remove imagem antiga se existir
            if ($bike->image && \Storage::disk('public')->exists($bike->image)) {
                \Storage::disk('public')->delete($bike->image);
            }
            $data['image'] = $request->file('image')->store('bikes', 'public');
        }

        $bike->update($data);

        return redirect()->route('bikes.index')
                         ->with('success', 'Produto "' . $bike->name . '" atualizado com sucesso!');
    }

    public function destroy(Bike $bike)
    {
        if ($bike->image && \Storage::disk('public')->exists($bike->image)) {
            \Storage::disk('public')->delete($bike->image);
        }

        $name = $bike->name;
        $bike->delete();

        return redirect()->route('bikes.index')
                         ->with('success', 'Produto "' . $name . '" excluído com sucesso!');
    }
}