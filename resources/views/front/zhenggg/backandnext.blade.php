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
<script>
    $(function () {
        $('.box-footer').hide();
    });

    function tabnext(which) {
        if ((which+1) == '{{$max}}'){
            $('.box-footer').show();
        }
        $('.nav-tabs').children().removeClass('active');
        $('.nav-tabs').children().eq(which).addClass('active');

        $('.tab-content').children().removeClass('active');
        $('.tab-content').children().eq(which).addClass('active');
    }

    function tabback(which) {
        var eq = which -2;
        $('.nav-tabs').children().removeClass('active');
        $('.nav-tabs').children().eq(eq).addClass('active');

        $('.tab-content').children().removeClass('active');
        $('.tab-content').children().eq(eq).addClass('active');
    }
</script>

