<script>
    var selectp = {
        htmlspecialchars_decode: function (str) {
            str = str.replace(/&amp;/g, '&');
            str = str.replace(/&lt;/g, '<');
            str = str.replace(/&gt;/g, '>');
            str = str.replace(/&quot;/g, "\"");
            str = str.replace(/&#039;/g, "'");
            return str;
        },
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

                    var html_h = selectp.htmlspecialchars_decode('{{$html}}');

                    html_h = html_h.replace(/thereplacestring/, data.c_price);

                    $(html_h).insertAfter($("#tab-form-2 .form-group").first());

                }
            });
        }
    }

    $('.p_id').change(function () {
        selectp.getData();
    });

    $(function () {
        selectp.getData();
    });

</script>