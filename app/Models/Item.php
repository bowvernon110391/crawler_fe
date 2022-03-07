<?php

namespace App\Models;

use App\Traits\StandardDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Item class, representing an item
 */
class Item extends Model
{
    use HasFactory;
    use StandardDate;

    // standard attributes
    /* protected $attributes = [

    ]; */

    // fillables?
    protected $fillable = [
        'crawling_job_id',
        'item_id',
        'name',
        'url',
        'image_url',
        'rating',
        'rating_avg',
        'price',
        'view_count',
        'wishlist_count',
        'category_id',
        'shop_id'
    ];

    // casts
    protected $casts = [
        'price' => 'float',
        'rating' => 'float',
        'rating_avg' => 'float',
    ];

    // some relations
    public function shop() {
        return $this->belongsTo(Shop::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function crawlingJob() {
        return $this->belongsTo(CrawlingJob::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
