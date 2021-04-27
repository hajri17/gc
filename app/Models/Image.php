<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 *
 * @property int $id
 * @property string $url
 * @property string|null $label
 * @property string|null $description
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|Item[] $items
 * @property Item $item
 *
 * @package App\Models
 */
class Image extends Model
{
	protected $table = 'images';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'url',
		'label',
		'description',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function items()
	{
		return $this->belongsToMany(Item::class)
					->withPivot('id');
	}

	public function item()
    {
        return $this->hasOne(Item::class, 'main_image_id', 'id');
    }
}
