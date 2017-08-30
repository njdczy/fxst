<?php


namespace App\Front\Extensions\Column;


use App\Zhenggg\Facades\Front;
use App\Zhenggg\Grid\Displayers\AbstractDisplayer;

use QrCode;
class QrCodeColumn extends AbstractDisplayer
{
    protected function script()
    {

        return <<<EOT

$('.grid-qrcode').popover({
    title: "专属订购二维码",
    html: true,
    trigger: 'hover',
    placement: 'right',
    template: '<div class="popover"   role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
});

new Clipboard('.clipboard');

$('.clipboard').tooltip({
  trigger: 'click',
  placement: 'bottom'
}).mouseout(function (e) {
    $(this).tooltip('hide');
});

EOT;

    }

    public function display()
    {
        Front::script($this->script());
        $qrcode = "<img src='data:image/png;base64,"
                    . base64_encode(
                        QrCode::format("png")
                            //->merge(asset('images/logo/logo'.\Front::user()->id.'.png'), .28,true)
                            ->errorCorrection('H')
                            ->size(140)
                            ->generate(url("/form/" . $this->getKey()))
                    )
                    . "'  style='height: 140px;width: 140px;' />";
//        $value = url("/form/" . $this->getKey());
//        $qrcode = "<img src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={$value}' style='height: 150px;width: 150px;'/>";

        return <<<EOT

<div class="input-group" style="width:150px;">
  <span class="input-group-btn">
    <a class="btn btn-default btn-sm grid-qrcode" data-content="$qrcode" data-toggle='popover' tabindex='0'>
        <i class="fa fa-qrcode"></i>
    </a>
  </span>
</div>

EOT;

    }
}