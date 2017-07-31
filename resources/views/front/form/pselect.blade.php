<div class="form-group {!! !$errors->has($column) ?: 'has-error' !!}">

    <label for="{{$id}}" class="col-sm-{{$width['label']}} control-label">{{$label}}</label>

    <div class="col-sm-{{$width['field']}}" id="{{$id}}">

        @include('front::form.error')

        @foreach($options as $option => $label)
            @if(!$inline)<div class="checkbox">@endif
                <label @if($inline)class="checkbox-inline"@endif>
                    <input type="checkbox" name="{{$name}}[]" value="{{$option}}" class="{{$class}}" {{ in_array($option, (array)old($column, $value))?'checked':'' }} {!! $attributes !!} />&nbsp;{{$label}}&nbsp;&nbsp;
                </label>
                @if(!$inline)</div>@endif
        @endforeach

        <input type="hidden" name="{{$name}}[]">
        {{--<table cellspacing='1' id="list-table">--}}
            {{--{foreach from=$priv_arr item=priv}--}}
            {{--<tr>--}}
                {{--<td width="18%" valign="top" class="first-cell">--}}
                    {{--<input name="chkGroup" type="checkbox" value="checkbox" onclick="check('{$priv.priv_list}',this);" class="checkbox">{$lang[$priv.action_code]}--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--{foreach from=$priv.priv key=priv_list item=list}--}}
                    {{--<div style="width:200px;float:left;">--}}
                        {{--<label for="{$priv_list}"><input type="checkbox" name="action_code[]" value="{$priv_list}" id="{$priv_list}" class="checkbox" {if $list.cando eq 1} checked="true" {/if} onclick="checkrelevance('{$list.relevance}', '{$priv_list}')" title="{$list.relevance}"/>--}}
                            {{--{$lang[$list.action_code]}</label>--}}
                    {{--</div>--}}
                    {{--{/foreach}--}}
                {{--</td></tr>--}}
            {{--{/foreach}--}}
            {{--<tr>--}}
                {{--<td align="center" colspan="2" >--}}
                    {{--<input type="checkbox" name="checkall" value="checkbox" onclick="checkAll(this.form, this);" class="checkbox" />{$lang.check_all}--}}
                    {{--&nbsp;&nbsp;&nbsp;&nbsp;--}}
                    {{--<input type="submit"   name="Submit"   value="{$lang.button_save}" class="button" />&nbsp;&nbsp;&nbsp;--}}
                    {{--<input type="reset" value="{$lang.button_reset}" class="button" />--}}
                    {{--<input type="hidden"   name="id"    value="{$user_id}" />--}}
                    {{--<input type="hidden"   name="act"   value="{$form_act}" />--}}
                {{--</td>--}}
            {{--</tr>--}}
        {{--</table>--}}
        @include('front::form.help-block')

    </div>
</div>
