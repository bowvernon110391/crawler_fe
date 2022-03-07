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
}
