<?php
namespace App\Services\SSO;

use App\Models\SSO\User;

class UserService {

    public function cacheUserObject($userData, string $token): ?User {
        return User::cacheUserObject($userData, $token);
    }
}