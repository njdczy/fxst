<?php

namespace App\Zhenggg\Widgets\Chart;

use App\Zhenggg\Front;
use App\Zhenggg\Widgets\Widget;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;

class Chart extends Widget implements Renderable
{
    protected $elementId = '';

    protected $options = [];

    protected $data = [];

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function makeElementId()
    {
        return 'chart_'.str_replace('.', '', uniqid('', true));
    }

    public static function color($color = '')
    {
        $colors = ['#dd4b39', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'];

        return $color ? $color : $colors[array_rand($colors)];

        //sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function options($options = [])
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @param $data
     *
     * @deprecated
     */
    public function data($data)
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        $this->data = $data;
    }

    public function render()
    {
        $this->elementId = $this->makeElementId();

        Front::script($this->script());

        return view('front::widgets.chart', ['id' => $this->elementId])->render();
    }
}
