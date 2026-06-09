<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

final class ProductStoreRequest extends FormRequest
{
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
        Rule::unique('products')->where(
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
