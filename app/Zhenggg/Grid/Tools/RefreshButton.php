<?php

namespace App\Zhenggg\Grid\Tools;

use App\Zhenggg\Front;

class RefreshButton extends AbstractTool
{
    /**
     * Script for this tool.
     *
     * @return string
     */
    protected function script()
    {
        $message = trans('front::lang.refresh_succeeded');

        return <<<EOT

$('.grid-refresh').on('click', function() {
    $.pjax.reload('#pjax-container');
    toastr.success('{$message}');
});

EOT;
    }

    /**
     * Render refresh button of grid.
     *
     * @return string
     */
    public function render()
    {
        Front::script($this->script());

        $refresh = trans('front::lang.refresh');

        return <<<EOT
<a class="btn btn-sm btn-primary grid-refresh"><i class="fa fa-refresh"></i> $refresh</a>
EOT;
    }
}
