<script>
    $('table').DataTable({
        'fnDrawCallback': function(oSettings) {}
    });

    $(document).ready(function() {
        $('.btn-delete').click(function() {
            let id = $(this).attr('data-id');
            function_delete(id, '<?= base_url('parameter/delete') ?>');
        })
    });

    <?php if (@$_mode == "edit") : ?>

        function reload_voltage() {
            if ($("#labjack_value_id").val() > 0) {
                $.get("<?= base_url(); ?>/labjack_value/get_labjack_id_ain_id/" + $("#labjack_value_id").val(), function(labjack_value) {
                    labjack_value = JSON.parse(labjack_value);
                    $.get("<?= base_url(); ?>/labjack_value/get/" + labjack_value.labjack_id + "/" + labjack_value.ain_id, function(result) {
                        $('#voltage').val(result);
                    });
                });
            } else {
                $('#voltage').val(0);
            }

            setTimeout(function() {
                reload_voltage();
            }, 1000);
        }
        reload_voltage();
    <?php endif ?>

    function generate_formula() {
        $.get("<?= base_url(); ?>/labjack_value/get_labjack_id_ain_id/" + $("#labjack_value_id").val(), function(labjack_value) {
            labjack_value = JSON.parse(labjack_value);
            var a = 0.0;
            var b = 0.0;
            var sign = "";
            a = ($("#concentration2").val() - $("#concentration1").val()) / ($("#voltage2").val() - $("#voltage1").val());
            b = $("#concentration1").val() - (a * $("#voltage1").val());
            if (b < 0) {
                b = b * -1;
                sign = "-";
            } else sign = "+";
            var formula = "round((" + a + " * " + "$labjack[" + labjack_value.labjack_id + "][" + labjack_value.ain_id + "]) " + sign + " " + b + ",6)";
            $("#formula").val(formula);
        });
    }
</script>