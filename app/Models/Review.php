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
 * @property int|null $item_id
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Item|null $item
 * @property User|null $user
 *
 * @package App\Models
 */
class Review extends Model
{
	protected $table = 'reviews';

	protected $casts = [
		'stars' => 'int',
		'item_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'stars',
		'content',
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
