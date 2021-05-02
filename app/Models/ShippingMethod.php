<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingMethod
 * 
 * @property int $id
 * @property string $name
 * @property float $price_per_kg
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Transaction[] $transactions
 *
 * @package App\Models
 */
class ShippingMethod extends Model
{
	protected $table = 'shipping_methods';

	protected $casts = [
		'price_per_kg' => 'float'
	];

	protected $fillable = [
		'name',
		'price_per_kg'
	];

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}
}
