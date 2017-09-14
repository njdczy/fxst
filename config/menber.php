<?php
return [

    /*
     * Laravel-admin name.
     */
    'name'      => '发行管理系统-个人',

    /*
     * Logo in admin panel header.
     */
    'logo'      => '发行管理系统-个人',

    /*
     * Mini-logo in admin panel header.
     */
    'logo-mini' => '<b>发行管理-个人</b>',

    /*
     * Laravel-admin url prefix.
     */
    'prefix'    => 'menber',

    /*
     * Laravel-admin install directory.
     */
    'directory' => app_path('Menber'),

    /*
     * Laravel-front html title.
     */
    'title'  => '发行管理系统-个人',

    /*
     * Laravel-front auth setting.
     */
    'auth' => [
        'driver'   => 'session',
        'provider' => '',
        'model'    => App\Models\Menber::class,
    ],

    /*
     * Laravel-admin upload setting.
     */
    'upload'  => [

        'disk' => 'menber',

        'directory'  => [
            'image'  => 'image',
            'file'   => 'file',
        ],

        'host' => 'http://f.xhbuy.cn/upload/',
    ],

    /*
     * Laravel-admin database setting.
     */
    'database' => [

        // Database connection for following tables.
        'connection'  => '',

        // User tables and model.
        'users_table' => 'menbers',
        'users_model' => App\Models\Menber::class,


        // Menu table and model.
        'menu_table'  => 'menber_menu',
        'menu_model'  => App\Menber\Auth\Database\Menu::class,
    ],

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