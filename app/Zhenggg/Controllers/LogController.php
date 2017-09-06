<?php

namespace App\Zhenggg\Controllers;

use App\Zhenggg\Auth\Database\Administrator;
use App\Zhenggg\Auth\Database\OperationLog;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Routing\Controller;

class LogController extends Controller
{
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Front::content(function (Content $content) {
            $content->header(trans('front::lang.operation_log'));
            $content->description(trans('front::lang.list'));

            $grid = Front::grid(OperationLog::class, function (Grid $grid) {
                $grid->model()->orderBy('id', 'DESC');

                $grid->id('ID')->sortable();
                $grid->user()->name();
                $grid->method()->value(function ($method) {
                    $color = array_get(OperationLog::$methodColors, $method, 'grey');

                    return "<span class=\"badge bg-$color\">$method</span>";
                });
                $grid->path()->label('info');
                $grid->ip()->label('primary');
                $grid->input()->value(function ($input) {
                    $input = json_decode($input, true);
                    $input = array_except($input, '_pjax');

                    return '<code>'.json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).'</code>';
                });

                $grid->created_at(trans('front::lang.created_at'));

                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->disableEdit();
                });

                $grid->disableCreation();

                $grid->filter(function ($filter) {
                    $filter->is('user_id', 'User')->select(Administrator::all()->pluck('name', 'id'));
                    $filter->is('method')->select(array_combine(OperationLog::$methods, OperationLog::$methods));
                    $filter->like('path');
                    $filter->is('ip');

                    $filter->useModal();
                });
            });

            $content->body($grid);
        });
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);

        if (OperationLog::destroy(array_filter($ids))) {
            return response()->json([
                'status'  => true,
                'message' => trans('front::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('front::lang.delete_failed'),
            ]);
        }
    }
}
