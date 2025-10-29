<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read float $unit_price
 * @property-read ?float $revenue
 * @property-read ?float $capacity
 * @property-read ?User $user
 */
final class Product extends Model
{
  protected $fillable = [
    'name',
    'unit_price',
    'revenue',
    'capacity',
  ];

  /** @return BelongsTo<User> */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
