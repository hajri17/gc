<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 *
 * @property int $id
 * @property int $stars
 * @property string|null $content
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $transaction_id
 *
 * @property Transaction $transaction
 * @property User|null $user
 *
 * @package App\Models
 */
class Review extends Model
{
	protected $table = 'reviews';

	protected $casts = [
		'stars' => 'int',
		'user_id' => 'int',
        'item_id' => 'int',
		'transaction_id' => 'int'
	];

	protected $fillable = [
		'stars',
		'content',
		'user_id',
        'item_id',
		'transaction_id'
	];

	public function transaction()
	{
		return $this->belongsTo(Transaction::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function item()
    {
        return $this->belongsTo(Item::class);
	}
}
