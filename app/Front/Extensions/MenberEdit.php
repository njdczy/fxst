<?php


namespace App\Front\Extensions;


use App\Zhenggg\Grid\Tools\AbstractTool;

class MenberEdit extends AbstractTool
{

    protected function script()
    {
        return <<<EOT
    
$("#menberedit-modal .submit").click(function () {
    $("#menberedit-modal").modal('toggle');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
});

EOT;
    }

    public function render()
    {
        \Front::script($this->script());


        return view('front::zhenggg.menbereditmodal');
    }
}