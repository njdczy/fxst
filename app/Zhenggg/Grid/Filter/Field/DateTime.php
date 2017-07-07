<?php

namespace App\Zhenggg\Grid\Filter\Field;

use App\Zhenggg\Front;

class DateTime
{
    /**
     * @var \App\Zhenggg\Grid\Filter\AbstractFilter
     */
    protected $filter;

    protected $options = [];

    public function __construct($filter, array $options = [])
    {
        $this->filter = $filter;

        $this->options = $this->checkOptions($options);

        $this->prepare();
    }

    public function prepare()
    {
        $script = "$('#{$this->filter->getId()}').datetimepicker(".json_encode($this->options).');';

        Front::script($script);
    }

    public function variables()
    {
        return [];
    }

    public function name()
    {
        return 'datetime';
    }

    protected function checkOptions($options)
    {
        $options['format'] = array_get($options, 'format', 'YYYY-MM-DD HH:mm:ss');
        $options['locale'] = array_get($options, 'locale', config('app.locale'));

        return $options;
    }
}
