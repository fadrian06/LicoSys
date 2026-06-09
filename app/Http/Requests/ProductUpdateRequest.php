<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

final class ProductUpdateRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    $product = $this->route('product');

    return $product->user->id === Auth::id();
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => [
        'required',
        'string',
        'max:255',
        Rule::unique('products')
          ->ignore($this->product->id)
          ->where(
            fn($query) => $query
              ->where('capacity', $this->capacity)
              ->where('user_id', Auth::id())
          )
      ],
      'unit_price' => 'required|numeric|min:0',
      'revenue' => 'required|numeric|min:0',
      'capacity' => 'required|numeric|min:0',
    ];
  }
}
