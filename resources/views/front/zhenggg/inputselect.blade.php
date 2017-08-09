

<script>

    $('.p_id').change(function () {
        var selectp = {
            getData: function () {
                var url = '{{\Front::url('selectp')}}';
                var p_id = $('.p_id').val();
                $.ajax({
                    method: 'get',
                    url: url,
                    data: {
                        p_id: p_id,
                    },
                    success: function (data) {
                        $('.selectp').remove();
                        var html = '{{$html}}';
                        var html_h = htmlspecialchars_decode(html);
                        $(html_h).insertAfter($("#tab-form-2 .form-group").first());

                    }
                });
            }
        }
        selectp.getData();
    });
    function htmlspecialchars_decode(str){
        str = str.replace(/&amp;/g, '&');
        str = str.replace(/&lt;/g, '<');
        str = str.replace(/&gt;/g, '>');
        str = str.replace(/&quot;/g, "\"");
        str = str.replace(/&#039;/g, "'");
        return str;
    }
    $(function () {
        var selectp = {
            getData: function () {
                var url = '{{\Front::url('selectp')}}';
                var p_id = $('.p_id').val();
                $.ajax({
                    method: 'get',
                    url: url,
                    data: {
                        p_id: p_id,
                    },
                    success: function (data) {
                        $('.selectp').remove();
                        var html = '{{$html}}';
                        var html_h = htmlspecialchars_decode(html);
                        $(html_h).insertAfter($("#tab-form-2 .form-group").first());

                    }
                });
            }
        }
        selectp.getData();
    });

</script>