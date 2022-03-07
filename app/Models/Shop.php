<?php

namespace App\Models;

use App\Traits\StandardDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    use StandardDate;

    protected $fillable = [
        'shop_id',
        'name',
        'url',
        'domain',
        'kota',
        'alamat',
        'kode_pos',
        'lat',
        'lon',
        'last_active',
        'registered_at',
        'marketplace',
    ];

    protected $casts = [
        'lat' => 'float',
        'lon' => 'float',
        'kode_pos' => 'string'
    ];

    // RELATIONS
    public function items() {
        return $this->hasMany(Item::class);
    }
}
