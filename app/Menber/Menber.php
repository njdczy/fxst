<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 * Time: 15:28
 */

namespace App\Menber;

use Closure;
use App\Menber\Auth\Database\Menu;
use App\Menber\Layout\Content;
use App\Menber\Widgets\Navbar;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use InvalidArgumentException;

class Menber
{
    /**
     * @var Navbar
     */
    protected $navbar;

    /**
     * @var array
     */
    public static $script = [];

    /**
     * @var array
     */
    public static $css = [];

    /**
     * @var array
     */
    public static $js = [];

    /**
     * @param $model
     * @param Closure $callable
     *
     * @return \App\Menber\Grid
     */
    public function grid($model, Closure $callable)
    {
        return new Grid($this->getModel($model), $callable);
    }

    /**
     * @param $model
     * @param Closure $callable
     *
     * @return \App\Menber\Form
     */
    public function form($model, Closure $callable)
    {
        return new Form($this->getModel($model), $callable);
    }

    /**
     * Build a tree.
     *
     * @param $model
     *
     * @return \App\Menber\Tree
     */
    public function tree($model, Closure $callable = null)
    {
        return new Tree($this->getModel($model), $callable);
    }

    /**
     * @param Closure $callable
     *
     * @return \App\Menber\Layout\Content
     */
    public function content(Closure $callable = null)
    {
        return new Content($callable);
    }

    /**
     * @param $model
     *
     * @return mixed
     */
    public function getModel($model)
    {
        if ($model instanceof EloquentModel) {
            return $model;
        }

        if (is_string($model) && class_exists($model)) {
            return $this->getModel(new $model());
        }

        throw new InvalidArgumentException("$model is not a valid model");
    }

    /**
     * Get namespace of controllers.
     *
     * @return string
     */
    public function controllerNamespace()
    {
        $directory = config('menber.directory');

        return ltrim(implode('\\',
                array_map('ucfirst',
                    explode(DIRECTORY_SEPARATOR, str_replace(app()->basePath(), '', $directory)))), '\\')
            .'\\Controllers';
    }

    /**
     * Add css or get all css.
     *
     * @param null $css
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public static function css($css = null)
    {
        if (!is_null($css)) {
            self::$css = array_merge(self::$css, (array) $css);

            return;
        }

        $css = array_get(Form::collectFieldAssets(), 'css', []);

        static::$css = array_merge(static::$css, $css);

        return view('menber::partials.css', ['css' => array_unique(static::$css)]);
    }

    /**
     * Add js or get all js.
     *
     * @param null $js
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public static function js($js = null)
    {
        if (!is_null($js)) {
            self::$js = array_merge(self::$js, (array) $js);

            return;
        }

        $js = array_get(Form::collectFieldAssets(), 'js', []);

        static::$js = array_merge(static::$js, $js);

        return view('menber::partials.js', ['js' => array_unique(static::$js)]);
    }

    /**
     * @param string $script
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public static function script($script = '')
    {
        if (!empty($script)) {
            self::$script = array_merge(self::$script, (array) $script);

            return;
        }

        return view('menber::partials.script', ['script' => array_unique(self::$script)]);
    }

    /**
     * Admin url.
     *
     * @param $url
     *
     * @return string
     */
    public static function url($url)
    {
        $prefix = (string) config('menber.prefix');

        if (empty($prefix) || $prefix == '/') {
            return '/'.trim($url, '/');
        }

        return "/$prefix/".trim($url, '/');
    }

    /**
     * Left sider-bar menu.
     *
     * @return array
     */
    public function menu()
    {
        return (new Menu())->toTree();
    }

    /**
     * Get admin title.
     *
     * @return Config
     */
    public function title()
    {
        return config('menber.title');
    }

    /**
     * Get current login user.
     *
     * @return mixed
     */
    public function user()
    {
        return Auth::guard('menber')->user();
    }

    /**
     * Set navbar.
     *
     * @param Closure $builder
     */
    public function navbar(Closure $builder)
    {
        call_user_func($builder, $this->getNavbar());
    }

    /**
     * Get navbar object.
     *
     * @return \App\Menber\Widgets\Navbar
     */
    public function getNavbar()
    {
        if (is_null($this->navbar)) {
            $this->navbar = new Navbar();
        }
        return $this->navbar;
    }

    public function registerAuthRoutes()
    {
        $attributes = [
            'prefix'        => config('menber.prefix'),
            'namespace'     => 'App\Menber\Controllers',
            'middleware'    => ['web', 'menber'],
        ];
        Route::group($attributes, function ($router) {
            $attributes = [];

            /* @var \Illuminate\Routing\Router $router */
            $router->group($attributes, function ($router) {
                $router->resource('users', 'UserController');
                $router->resource('menu', 'MenuController', ['except' => ['create']]);
            });
            $router->get('login', 'AuthController@getLogin');
            $router->post('login', 'AuthController@postLogin');
            $router->get('logout', 'AuthController@getLogout');
//            $router->get('auth/setting', 'AuthController@getSetting');
//            $router->put('auth/setting', 'AuthController@putSetting');
        });
    }

    public function registerHelpersRoutes($attributes = [])
    {
        $attributes = array_merge([
            'prefix'     => trim(config('menber.prefix'), '/').'/helpers',
            'middleware' => ['web', 'menber'],
        ], $attributes);

        Route::group($attributes, function ($router) {

            /* @var \Illuminate\Routing\Router $router */
            $router->get('scaffold', 'App\Menber\Controllers\ScaffoldController@index');
            $router->post('scaffold', 'App\Menber\Controllers\ScaffoldController@store');
        });
    }
}