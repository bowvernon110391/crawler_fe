<?php

namespace App\Models;

use App\Models\SSO\User;
use App\Traits\StandardDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrawlingJob extends Model
{
    use HasFactory;
    use StandardDate;

    const CREATED = 'CREATED';
    const PROCESSING = 'PROCESSING';
    const DONE = 'DONE';

    const DELIMITER = ';';

    // some guarded, and some defaults
    // protected $guarded = [ 'created_at', 'updated_at' ];
    protected $hidden = [ 'keyword_data' ];
    protected $fillable = [ 
        'keywords',
        'name',
        'private'
    ];

    protected $attributes = [
        'keyword_data' => ''    // empty by default
    ];

    protected $appends = [
        'keywords'
    ];

    protected $casts = [
        'private' => 'boolean'
    ];


    // RELATIONS
    public function user() {
        return $this->belongsTo(User::class);
    }

    // the real attributes as array
    public function getKeywordsAttribute() {
        return explode(';', $this->attributes['keyword_data']);
    }

    public function setKeywordsAttribute(array $data) {
        $this->attributes['keyword_data'] = implode(';', $data);
    }

    // local scope
    public function scopeByWildcard($query, $q='') {
        return $query->whereHas('user', function ($quser) use ($q) {
            return $quser->where('nama', 'like', "%$q%");
        })
        ->orWhere('name', 'like', "%$q%")
        ->orWhere('keyword_data', 'like', "%$q%");
    }

    public function scopeByUserId($query, $userId) {
        return $query->where('user_id', $userId);
    }
}
