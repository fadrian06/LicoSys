<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductDestroyRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): View
  {
    $user = Auth::user();
    assert($user instanceof User);

    return view('products.index', ['products' => $user->products]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): View
  {
    return view('products.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ProductStoreRequest $request): RedirectResponse
  {
    $validated = $request->validated();
    $user = $request->user();

    if ($user instanceof User) {
      $user->products()->create($validated);
    }

    return redirect()->route('products.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(Product $product): View
  {
    return view('products.show', ['product' => $product]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Product $product): View
  {
    return view('products.edit', [
      'product' => $product,
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
  {
    $validated = $request->validated();
    $product->update($validated);

    return redirect()->route('products.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ProductDestroyRequest $request, Product $product): RedirectResponse
  {
    $product->delete();

    return redirect()->route('products.index');
  }
}
