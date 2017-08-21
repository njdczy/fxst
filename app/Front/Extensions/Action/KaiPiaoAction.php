<?php


namespace App\Front\Extensions\Action;


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

<button class="btn btn-sm btn-primary kaipiao" data-id="{$this->id}"  data-toggle="modal" data-target="#grid-modal-kaipiao-{$this->id}">
   {$this->button_name}
</button>

<div class="modal fade" id="grid-modal-kaipiao-{$this->id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">{$this->button_name}</h4>
      </div>
      <div class="modal-body">
        <div style="height:450px;">
            <div class="form-group 1">
                <label for="baoshe_id" class="col-sm-2 control-label">开票信息</label>
                    <div class="col-sm-8">
                        <select class="form-control baoshe_id " style="width: 100%;" name="baoshe_id">
                            <option value="1" selected="">-------------------------------------</option>
                            <option value="2">-------------------------------------</option>
                        </select>
                    </div>
            </div>
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