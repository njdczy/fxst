<div class="form-group">
    <label for="{{$id}}" class="col-{{$width['label']}} control-label">{{$label}}</label>

    <div class="col-sm-{{$width['field']}}">
        <input type="text" id="{{$id}}" name="{{$name}}" value="{{$value}}" class="form-control" readonly {!! $attributes !!} />

        @include('menber::form.help-block')

    </div>
</div>