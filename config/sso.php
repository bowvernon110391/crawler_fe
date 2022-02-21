<?php

return [
    'url' => env('SSO_URL', ''),
    'broker' => env('SSO_BROKER', 0),
    'secret' => env('SSO_SECRET', '123456'),
    'login_url' => env('SSO_LOGIN_URL', 'https://lmgtfy?q=smegma'),
    'mock_user_id' => env('SSO_MOCK_USER_ID', 1)
];