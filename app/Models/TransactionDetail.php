<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionDetail
 * 
 * @property int $id
 * @property int $qty
 * @property float $price
 * @property float $discount
 * @property int|null $item_id
 * @property int|null $transaction_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Item|null $item
 * @property Transaction|null $transaction
 *
 * @package App\Models
 */
class TransactionDetail extends Model
{
	protected $table = 'transaction_details';

	protected $casts = [
		'qty' => 'int',
		'price' => 'float',
		'discount' => 'float',
		'item_id' => 'int',
		'transaction_id' => 'int'
	];

	protected $fillable = [
		'qty',
		'price',
		'discount',
		'item_id',
		'transaction_id'
	];

	public function item()
	{
		return $this->belongsTo(Item::class);
	}

	public function transaction()
	{
		return $this->belongsTo(Transaction::class);
	}
}
