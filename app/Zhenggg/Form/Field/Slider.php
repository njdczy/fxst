<?php

namespace App\Zhenggg\Form\Field;

use App\Zhenggg\Form\Field;

class Slider extends Field
{
    protected static $css = [
        '/packages/front/AdminLTE/plugins/ionslider/ion.rangeSlider.css',
        '/packages/front/AdminLTE/plugins/ionslider/ion.rangeSlider.skinNice.css',
    ];

    protected static $js = [
        '/packages/front/AdminLTE/plugins/ionslider/ion.rangeSlider.min.js',
    ];

    protected $options = [
        'type'     => 'single',
        'prettify' => false,
        'hasGrid'  => true,
    ];

    public function render()
    {
        $option = json_encode($this->options);

        $this->script = "$('{$this->getElementClassSelector()}').ionRangeSlider($option)";

        return parent::render();
    }
}
