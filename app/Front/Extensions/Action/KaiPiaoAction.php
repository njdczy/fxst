<?php


namespace app\Front\Extensions\Action;


class KaiPiaoAction
{
    protected $id;
    protected $button_name = '';

    public function __construct($id,$piao_status)
    {
        if ($piao_status == 0){
            $this->button_name = '开票';
        } elseif ($piao_status == 1) {
            $this->button_name = '查看';
        } elseif ($piao_status == 2) {

        } elseif ($piao_status == 3) {
            $this->button_name = '继续开票';
        }
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.kaipiao').on('click', function () {
    
    // Your code.
    console.log($(this).data('id'));
    
});

SCRIPT;
    }

    protected function render()
    {
        \Front::script($this->script());
        return <<<EOT

<button class="btn btn-xs btn-default kaipiao" data-id="{$this->id}"  data-toggle="modal" data-target="#grid-modal-kaipiao-{$this->id}">
   {$this->button_name}
</button>

<div class="modal" id="#grid-modal-kaipiao-{$this->id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">{$this->button_name}</h4>
      </div>
      <div class="modal-body">
        <div style="height:450px;"></div>
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