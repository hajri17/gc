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
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $name
 * @property string|null $address
 * @property string|null $shipping
 * @property string|null $description
 * @property string|null $card_number
 * @property string|null $card_name
 * @property Carbon|null $expiration_date
 * @property Carbon|null $paid_at
 * @property bool $is_cash
 * @property bool $is_canceled
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
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
		'user_id' => 'int'
	];

	protected $dates = [
		'expiration_date',
		'paid_at'
	];

	protected $fillable = [
		'email',
		'phone',
		'name',
		'address',
		'shipping',
		'description',
		'card_number',
		'card_name',
		'expiration_date',
		'paid_at',
		'is_cash',
		'is_canceled',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function transaction_details()
	{
		return $this->hasMany(TransactionDetail::class);
	}
}
