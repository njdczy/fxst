<?php

namespace App\Zhenggg\Widgets;

use Illuminate\Contracts\Support\Renderable;

class InfoBox extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'front::widgets.infoBox';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * InfoBox constructor.
     *
     * @param string $name
     * @param string $icon
     * @param string $color
     * @param string $link
     * @param string $info
     * @param string $more
     */
    public function __construct($name, $icon, $color, $link, $info, $more = '')
    {
        if ($more == '') {
            $more = trans('front::lang.more');
        }
        $this->data = [
            'name' => $name,
            'icon' => $icon,
            'link' => $link,
            'info' => $info,
            'more' => $more,
        ];

        $this->class("small-box bg-$color");
    }

    /**
     * @return string
     */
    public function render()
    {
        $variables = array_merge($this->data, ['attributes' => $this->formatAttributes()]);

        return view($this->view, $variables)->render();
    }
}
