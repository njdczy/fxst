<?php


namespace App\Front\Extensions\Action;


class KaiPiaoAction
{
    protected $id;
    protected $button_name = '';
    protected $piao_status;

    public function __construct($id, $piao_status)
    {
        $this->id = $id;
        $this->piao_status = $piao_status;

        if ($this->piao_status == 0) {
            $this->button_name = '开票';
        } elseif ($this->piao_status == 1) {
            $this->button_name = '查看';
        } elseif ($this->piao_status == 2) {

        } elseif ($this->piao_status == 3) {
            $this->button_name = '继续开票';
        }

    }

    protected function script()
    {
        return <<<SCRIPT

$('.kaipiao').on('click', function () {
            var id =  $(this).data('id');
            $(".head-piao").nextAll().remove();
             $.ajax({
                method: 'get',
                url: $(this).data('url'),
                success: function (data) {
                    
                    if (typeof data === 'object') {
                        $("#not_kai_money"+id).val(data.not_kai_money);
                       
                        $("#piao_name"+id).text(data.customer_piao.name);
                        $("#piao_hao"+id).text(data.customer_piao.hao);
                        $("#piao_addr"+id).text(data.customer_piao.addr);
                        $("#piao_phone"+id).text(data.customer_piao.phone);
                        $("#piao_bank"+id).text(data.customer_piao.bank);
                        $("#piao_bank_account"+id).text(data.customer_piao.bank_account);
                                                                
                        if ( !$.isEmptyObject(data.fapiaos) ) {
                              
                              $(".kaipiaolog-table").show();
                              $.each(data.fapiaos, function (n, value) {
                                   var trs = "";
                                   trs += "<tr><td>" + value.key + "</td> <td>" + value.should_kai_money + "</td><td>" + value.kai_money + "</td><td>" + value.haoma + "</td><td>" + value.created_at + "</td></tr>";
                                   $(trs).insertAfter($('.head-piao'));
                              }); 
                        } 
                    }
                }
            });
});

SCRIPT;
    }

    protected function render()
    {
        \Front::script($this->script());
        $url = \Front::url('/finance/fapiao/getdetail/' . $this->id);
        $form_url = \Front::url('/finance/fapiao/setdetail/' . $this->id);

        return view('front::zhenggg.action.KaiPiaoAction',
            [
                'id' => $this->id,
                'button_name' => $this->button_name,
                'piao_status' => $this->piao_status,
                'url' => $url,
                'form_url' => $form_url,
            ])->__toString();
    }

    public function __toString()
    {
        return $this->render();
    }
}