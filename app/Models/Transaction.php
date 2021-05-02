<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * 
 * @property int $id
 * @property string|null $proof
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $name
 * @property string|null $address
 * @property string|null $description
 * @property string|null $card_number
 * @property string|null $card_name
 * @property Carbon|null $expiration_date
 * @property string|null $shipping_number
 * @property Carbon|null $paid_at
 * @property Carbon|null $accepted_at
 * @property Carbon|null $shipped_at
 * @property bool $is_cash
 * @property bool $is_canceled
 * @property int|null $user_id
 * @property int $shipping_method_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ShippingMethod $shipping_method
 * @property User|null $user
 * @property Collection|Review[] $reviews
 * @property Collection|TransactionDetail[] $transaction_details
 *
 * @package App\Models
 */
class Transaction extends Model
{
	protected $table = 'transactions';

	protected $casts = [
		'is_cash' => 'bool',
		'is_canceled' => 'bool',
		'user_id' => 'int',
		'shipping_method_id' => 'int'
	];

	protected $dates = [
		'expiration_date',
		'paid_at',
		'accepted_at',
		'shipped_at'
	];

	protected $fillable = [
		'proof',
		'email',
		'phone',
		'name',
		'address',
		'description',
		'card_number',
		'card_name',
		'expiration_date',
		'shipping_number',
		'paid_at',
		'accepted_at',
		'shipped_at',
		'is_cash',
		'is_canceled',
		'user_id',
		'shipping_method_id'
	];

	public function shipping_method()
	{
		return $this->belongsTo(ShippingMethod::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}

	public function transaction_details()
	{
		return $this->hasMany(TransactionDetail::class);
	}
}
