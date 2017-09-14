<?php

namespace App\Menber\Grid\Displayers;

use App\Menber\Menber;

class SwitchDisplay extends AbstractDisplayer
{
    protected $states = [
        'on'  => ['value' => 1, 'text' => 'ON', 'color' => 'primary', 'disabled' => false],
        'off' => ['value' => 0, 'text' => 'OFF', 'color' => 'default', 'disabled' => false],
    ];

    protected function updateStates($states)
    {
        foreach (array_dot($states) as $key => $state) {
            array_set($this->states, $key, $state);
        }
    }

    public function display($states = [])
    {
        $this->updateStates($states);

        $name = $this->column->getName();

        $class = "grid-switch-{$name}";

        $disabled = '';
        if ( $this->states['on']['disabled'] == true) {
            $disabled = $this->states['on']['value'] == $this->value ? 'disabled' : '';
        } else if ( $this->states['off']['disabled'] == true) {
            $disabled = $this->states['off']['value'] == $this->value ? 'disabled' : '';
        }


        $key = $this->row->{$this->grid->getKeyName()};

        $checked = $this->states['on']['value'] == $this->value ? 'checked' : '';

        $script = <<<EOT

$('.$class').bootstrapSwitch({
    size:'mini',
    onText: '{$this->states['on']['text']}',
    offText: '{$this->states['off']['text']}',
    onColor: '{$this->states['on']['color']}',
    offColor: '{$this->states['off']['color']}',
    //disabled: '{$this->states['on']['disabled']}',
    onSwitchChange: function(event, state){

        $(this).val(state ? 'on' : 'off');
        _that = this;

        var pk = $(this).data('key');
        var value = $(this).val();

        $.ajax({
            url: "{$this->grid->resource()}/" + pk,
            type: "POST",
            data: {
                $name: value,
                _token: LA.token,
                _method: 'PUT'
            },
            success: function (data) {
                toastr.success(data.message);
                $(_that).parent().parent().addClass("bootstrap-switch-disabled");
                $(_that).attr('disabled','disabled');

            },

            error : function (data) {

               $(_that).parent().parent().addClass("bootstrap-switch-disabled");
                $(_that).attr('disabled','disabled');
                //$(_that).removeAttr('value');
            }
        });
    }
});

EOT;

        Menber::script($script);


        return <<<EOT
        <input type="checkbox" class="$class" $checked $disabled data-key="$key" />
EOT;
    }
}
