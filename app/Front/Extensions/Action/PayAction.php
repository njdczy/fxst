<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18
 * Time: 13:28
 */

namespace App\Front\Extensions\Action;


class PayAction
{
    protected $id;

    public function __construct($id,$pay_status)
    {

        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.pay').on('click', function () {
    
    // Your code.
    console.log($(this).data('id'));
    
});

SCRIPT;
    }

    protected function render()
    {
        \Front::script($this->script());
        return <<<EOT

<button class="btn btn-sm btn-primary pay" data-id="{$this->id}"  data-toggle="modal" data-target="#grid-modal-pay-{$this->id}">
   现金收款
</button>

<button class="btn btn-sm btn-primary pay" data-id="{$this->id}"  data-toggle="modal" data-target="#grid-modal-pay-{$this->id}">
   转账收款
</button>

<div class="modal fade" id="grid-modal-pay-{$this->id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">收款</h4>
      </div>
      <div class="modal-body">
        <div style="height:450px;">
            
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

EOT;
    }

    public function __toString()
    {
        return $this->render();
    }
}