<?php

namespace App\Models;

use App\Traits\StandardDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use StandardDate;

    protected $fillable = [
        'name'
    ];

    // relations?
    public function items() {
        return $this->hasMany(Item::class);
    }
}
