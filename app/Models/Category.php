<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @property int $id
 * @property string $name
 * @property int|null $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Category|null $category
 * @property Collection|Category[] $categories
 * @property Collection|Item[] $items
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'category_id' => 'int'
	];

	protected $fillable = [
		'name',
		'category_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function categories()
	{
		return $this->hasMany(Category::class);
	}

	public function items()
	{
		return $this->hasMany(Item::class);
	}
}
