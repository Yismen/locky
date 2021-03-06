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
     * Middlewares: array of middlewares to be applyied to package's routes. 
     */
    'middlewares' => ['web', 'auth'],
    /**
     * Models cointainer binding.
     */
    'models' => [
        'user' => \App\User::class,
        // 'permission' => \Dainsys\Locky\Models\Permission::class,
        // 'role' => \Dainsys\Locky\Models\Role::class,
    ],

    'icons' => [
        'both' => '&#x21f5;',
        'asc' => '&#8593;',
        'desc' => '&#8595;'
    ]
];
