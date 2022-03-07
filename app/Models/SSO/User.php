<?php

namespace App\Models\SSO;

use App\Traits\StandardDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Notifications\Notifiable;

class User extends AuthUser
{
    use Notifiable;
    use HasFactory;
    use StandardDate;

    protected $guarded = [
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'last_token',
        'role'
    ];

    protected $appends = [
        'roles'
    ];

    protected $casts = [
    ];

    // disable token
    public function disableToken() {
        // make our last_token unusable by adding marker at the beginning?
        $marker = base64_encode(date('Y-m-d H:i:s'));
        $this->last_token = $marker . '#' . $this->last_token;
        $this->save();
    }

    // scopes
    public function scopeByToken($q, string $token = '') {
        return $q->where('last_token', $token);
    }

    // attributes
    public function getRolesAttribute(): array {
        return array_filter( explode(',', $this->role), fn($e) => $e );
    }

    /**
     * check if we have such roles
     */
    public function hasRole($roles, bool $exact = false): bool {
        // just make sure it's an array
        if (!is_array($roles)) {
            $roles = [$roles];
        }

        // if we're not doing exact comparison, just return true when any matches found
        // otherwise the intersection count must be equal to criterions length
        return count(array_intersect($this->roles, $roles)) > ($exact ? count($roles) : 0);
    }

    // cache user data from sso
    public static function cacheUserObject($u, string $token): ?User {
        // build role string
        $role = $u['roleInfo']['crawler'] ?? [];
        $role_string = implode(',', array_map(fn($e) => preg_replace('/^crawler\./', '', $e['role']), $role) );

        // then, either update or create new user
        $user = User::updateOrCreate([
            'id' => $u['id'],
        ], [
            'username' => $u['username'],
            'group' => $u['group'],
            'status' => $u['status'],
            'last_token' => $token,
            // detail
            'nama' => $u['detil']['nama'],
            'nip' => $u['detil']['nip'],
            'kantor' => $u['detil']['kantor'],
            'kantor_id' => $u['detil']['kantor_id'],
            'kantor_level' => $u['detil']['kantor_level'],
            'kode_eselon2' => $u['detil']['kode_eselon2'],
            'eselon2' => $u['detil']['eselon2'],
            'kode_eselon3' => $u['detil']['kode_eselon3'],
            'eselon3' => $u['detil']['eselon3'],
            // role string as comma separated value, explode in attribute
            'role' => $role_string
        ]);

        return $user;
    }
}
