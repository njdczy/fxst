<div class="col-sm-2">

</div>
<div class="col-sm-8">
    @if($is_last != true)
        <div class="btn-group pull-right">
            <a href="#tab-form-{{$which+1}}" onclick="tabnext({{$which}})" type="submit"
               class="btn btn-info pull-right">
                下一步
            </a>
        </div>
    @endif

    @if($which != 1)
        <div class="btn-group pull-left">
            <a href="#tab-form-{{$which-1}}" onclick="tabback({{$which}})" type="submit"
               class="btn btn-warning pull-right">
                上一步
            </a>
        </div>
    @endif
</div>


