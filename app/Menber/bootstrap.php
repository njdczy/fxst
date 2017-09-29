<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */


use App\Menber\Exception\Column\ExpandRow;
use App\Menber\Grid\Column;

App\Menber\Form::forget(['map', 'editor']);

Column::extend('expand', ExpandRow::class);

//更改后台视图文件位置
app('view')->prependNamespace('menber', resource_path('views/menber'));

//使用中文语言包
app('translator')->addNamespace('menber', resource_path('lang/menber'));