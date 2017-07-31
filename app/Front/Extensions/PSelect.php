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
    protected $inline = true;

    protected static $css = [
        '/packages/front/AdminLTE/plugins/iCheck/all.css',
    ];

    protected static $js = [
        'packages/front/AdminLTE/plugins/iCheck/icheck.min.js',
    ];


    private function getUrl()
    {
        return url()->current() ;
    }

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
     * Draw inline checkboxes.
     */
    public function inline()
    {
        $this->inline = true;
    }

    /**
     * Draw stacked checkboxes.
     */
    public function stacked()
    {
        $this->inline = false;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->script = <<<EOT
$('{$this->getElementClassSelector()}').on('ifChecked', function(event){
    val = this.value;
    $.ajax({
         type: 'get',
         url: '{$this->getUrl()}/pselect' ,
         data: {val:val} ,
         dataType: 'json',
         success: function(data){
            if(data) {
                data.parent_id
            }
         }
    });
});
$('{$this->getElementClassSelector()}').iCheck({checkboxClass:'icheckbox_minimal-blue'});


EOT;

        return parent::render()->with('inline', $this->inline);
    }
}