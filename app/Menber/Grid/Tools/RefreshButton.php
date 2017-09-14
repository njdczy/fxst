<?php

namespace App\Menber\Grid\Tools;

use App\Menber\Menber;

class RefreshButton extends AbstractTool
{
    /**
     * Script for this tool.
     *
     * @return string
     */
    protected function script()
    {
        $message = trans('menber::lang.refresh_succeeded');

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
        Menber::script($this->script());

        $refresh = trans('menber::lang.refresh');

        return <<<EOT
<a class="btn btn-sm btn-info grid-refresh"><i class="fa fa-refresh"></i> $refresh</a>
EOT;
    }
}
