<?php

namespace App\Models\SSO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser
{
    use HasFactory;

    protected $guarded = [
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'last_token'
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

    // helper
    /**
     * Update or create new user
     */
    /* {
        "username": "tri.mulyadi",
        "id": "2",
        "group": "beacukai",
        "status": "enabled",
        "detil": {
            "nama": "Tri Mulyadi Wibowo",
            "nip": "199103112012101001",
            "pangkat": "Penata Muda - III/a",
            "kode_eselon2": "005000",
            "eselon2": "Direktorat P2",
            "kode_eselon3": null,
            "eselon3": null,
            "kantor": "Direktorat P2",
            "kantor_id": "005000",
            "kantor_level": "eselon2"
        },
        "roleInfo": {
            "siroleg": [
                {
                    "role": "siroleg.administrator",
                    "role_name": "Administrator",
                    "name": "siroleg",
                    "domains": "siroleg.beacukai.go.id",
                    "description": "Siroleg",
                    "icon": null
                }
            ],
            "appsmanager": [
                {
                    "role": "bc.administrator",
                    "role_name": "Administrator Beacukai",
                    "name": "appsmanager",
                    "domains": "app.siroleg.xyz",
                    "description": null,
                    "icon": null
                }
            ]
        }
    } */
    public static function cacheUserObject($u, string $token): ?User {
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
            'eselon3' => $u['detil']['eselon3']
        ]);

        return $user;
    }
}
