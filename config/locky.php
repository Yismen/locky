<?php

return [
    /**
     * Email address of the user who will be acting as super user.
     */
    'super_user_email' => env('LOCKY_SUPER_USER_EMAIL'),
    /**
     * Determine if package migrations will be auto discovered. Set to false if you are using your ouwn migrations. Alternatevely you can publish package migrations and modify as needed.
     */
    'with_migrations' => true,
    /**
     * With this setup we define if laravel/ui Auth::rotues() will be made available. 
     * Change to false if you are doing your own implementation.
     */
    'with_auth_routes' => true,
    /**
     * Middlewares: array of middlewares to be applyied to package's routes. 
     */
    'middlewares' => ['web', 'auth'],
];
