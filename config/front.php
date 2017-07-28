<?php

return [

    /*
     * Laravel-admin name.
     */
    'name'      => '发行管理系统front',

    /*
     * Logo in admin panel header.
     */
    'logo'      => '<b>发行管理系统</b> front',

    /*
     * Mini-logo in admin panel header.
     */
    'logo-mini' => '<b>发行管理</b>',

    /*
     * Laravel-admin url prefix.
     */
    'prefix'    => 'front',

    /*
     * Laravel-admin install directory.
     */
    'directory' => app_path('Front'),

    /*
     * Laravel-front html title.
     */
    'title'  => '发行管理系统',

    /*
     * Laravel-front auth setting.
     */
    'auth' => [
        'driver'   => 'session',
        'provider' => '',
        'model'    => App\Zhenggg\Auth\Database\Administrator::class,
    ],

    /*
     * Laravel-admin upload setting.
     */
    'upload'  => [

        'disk' => 'front',

        'directory'  => [
            'image'  => 'image',
            'file'   => 'file',
        ],

        'host' => 'http://fxst.app/upload/',
    ],

    /*
     * Laravel-admin database setting.
     */
    'database' => [

        // Database connection for following tables.
        'connection'  => '',

        // User tables and model.
        'users_table' => 'front_users',
        'users_model' => App\Zhenggg\Auth\Database\Administrator::class,

        // Role table and model.
        'roles_table' => 'front_roles',
        'roles_model' => App\Zhenggg\Auth\Database\Role::class,

        // Permission table and model.
        'permissions_table' => 'front_permissions',
        'permissions_model' => App\Zhenggg\Auth\Database\Permission::class,

        // Menu table and model.
        'menu_table'  => 'front_menu',
        'menu_model'  => App\Zhenggg\Auth\Database\Menu::class,

        // Pivot table for table above.
        'operation_log_table'    => 'front_operation_log',
        'user_permissions_table' => 'front_user_permissions',
        'role_users_table'       => 'front_role_users',
        'role_permissions_table' => 'front_role_permissions',
        'role_menu_table'        => 'front_role_menu',
        'user_menu_table'        => 'front_user_menu',
    ],

    /*
     * By setting this option to open or close operation log in laravel-admin.
     */
    'operation_log'   => true,

    /*
    |---------------------------------------------------------|
    | SKINS         | skin-blue                               |
    |               | skin-black                              |
    |               | skin-purple                             |
    |               | skin-yellow                             |
    |               | skin-red                                |
    |               | skin-green                              |
    |---------------------------------------------------------|
     */
    'skin'    => 'skin-blue',

    /*
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |
    |               | sidebar-mini                            |
    |---------------------------------------------------------|
     */
    'layout'  => ['fixed'],

    /*
     * Version displayed in footer.
     */
    'version'   => '1.0',
];
