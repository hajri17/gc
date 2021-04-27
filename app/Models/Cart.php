<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 * 
 * @property int $id
 * @property int $qty
 * @property int $item_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Item $item
 * @property User $user
 *
 * @package App\Models
 */
class Cart extends Model
{
	protected $table = 'carts';

	protected $casts = [
		'qty' => 'int',
		'item_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'qty',
		'item_id',
		'user_id'
	];

	public function item()
	{
		return $this->belongsTo(Item::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
