<?php

namespace App\Zhenggg\Form\Field;

class Date extends Text
{
    protected static $css = [
        '/packages/front/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
    ];

    protected static $js = [
        '/packages/front/moment/min/moment-with-locales.min.js',
        '/packages/front/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    ];

    protected $format = 'YYYY-MM-DD';

    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

    public function prepare($value)
    {
        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function render()
    {
        $this->options['format'] = $this->format;
        $this->options['locale'] = config('app.locale');

        $this->script = "$('{$this->getElementClassSelector()}').datetimepicker(".json_encode($this->options).');';

        $this->prepend('<i class="fa fa-calendar"></i>')
            ->defaultAttribute('style', 'width: 110px');

        return parent::render();
    }
}
