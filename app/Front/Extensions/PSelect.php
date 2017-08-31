<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/30
 * Time: 21:53
 */

namespace App\Front\Extensions;


use App\Zhenggg\Form\Field\MultipleSelect;
use Illuminate\Contracts\Support\Arrayable;

class PSelect extends MultipleSelect
{
    protected $view = 'front::zhenggg.permission_nodes';
    /**
     * Set options.
     *
     * @param array|callable|string $options
     *
     * @return $this|mixed
     */
    public function options($options = [])
    {
        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        $this->options = (array) $options;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return parent::render()->with(['nodes' => $this->options]);
    }
}