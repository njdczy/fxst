<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/31
 * Time: 17:15
 */

namespace App\Front\Extensions;


use App\Zhenggg\Facades\Front;

class MyDel
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        $confirm = trans('front::lang.delete_confirm');

        return <<<SCRIPT

$('.grid-row-delete').unbind('click').click(function() {
    if(confirm("{$confirm}")) {
        $.ajax({
            method: 'post',
            url: '{$this->getResource()}/' + $(this).data('id'),
            data: {
                _method:'delete',
                _token:LA.token,
            },
            success: function (data) {
                $.pjax.reload('#pjax-container');

                if (typeof data === 'object') {
                    if (data.status) {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }
            }
        });
    }
});

SCRIPT;
    }

    protected function render()
    {
        Front::script($this->script());
        return <<<EOT
<a href="javascript:void(0);" data-id="{$this->id}" class="grid-row-delete">
    <i class="fa fa-trash"></i>
</a>
EOT;
    }

    public function __toString()
    {
        return $this->render();
    }
}