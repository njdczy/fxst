<script>
    var selectp = {

        getData: function () {
            var url = '{{\Front::url('selectp')}}';
            var p_id = $('.p_id').val();
            var input_type = $('.input_type').val();
            $.ajax({
                method: 'get',
                url: url,
                data: {
                    p_id: p_id,
                    input_type: input_type,
                },
                success: function (data) {
                    $('#p_money').val(data.c_price);
                }
            });
        }
    }

    $('.input_type').change(function () {
        selectp.getData();
    });
    $('.p_id').change(function () {
        selectp.getData();
    });

    $(function () {
        console.log(11111);
        selectp.getData();
    });

</script>