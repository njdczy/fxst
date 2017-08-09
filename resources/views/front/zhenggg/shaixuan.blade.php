<div class="pull-left">
    <div class="form-inline pull-right">
        <form action="{{ url(\Front::url('')) }}?_pjax=%23pjax-container" method="get" pjax-container="">
            <fieldset>
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"><strong>所属部门</strong></span>
                    <select class="form-control d_id" style="width: 100%;" name="d_id">
                        @foreach($options as $select => $option)
                            <option value="{{$select}}" {{ (string)$select === request('d_id', $value) ?'selected':'' }}>{{$option}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="btn-group btn-group-sm">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    <a href="{{ url(\Front::url('')) }}/?_pjax=%23pjax-container" class="btn btn-warning"><i class="fa fa-undo"></i></a>
                </div>
            </fieldset>

        </form>
    </div>

</div>