<script>
    $(function () {
        var url = window.location.href;
        var container = '#tab-form-' + '{{$max}}';
        var is_contains =url.indexOf(container) >= 0;
        if (!is_contains){
            $('.box-footer').hide();
        }
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