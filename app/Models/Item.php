<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Category[] $categories
 * @property Collection|Image[] $images
 * @property Image $main_image
 *
 * @package App\Models
 */
class Item extends Model
{
	protected $table = 'items';

	protected $casts = [
		'price' => 'float'
	];

	protected $fillable = [
		'name',
		'price',
		'description',
        'category_id',
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function images()
	{
		return $this->belongsToMany(Image::class)
					->withPivot('id');
	}

    public function main_image()
    {
        return $this->belongsTo(Image::class, 'main_image_id', 'id');
	}

    public function reviews()
    {
        return $this->hasMany(Review::class);
	}
}
