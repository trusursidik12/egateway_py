<script>
    function reload_graph() {
        $.ajax({
            url: "<?= base_url(); ?>/home/graph/<?= $stack_id; ?>/",
            success: function(graphview) {
                try {
                    $("#graph").html(graphview);
                } catch (ex) {}
            }
        });
        setTimeout(function() {
            reload_graph();
        }, 3000);
    }

    function reload_measurement_log() {
        $.ajax({
            url: "<?= base_url(); ?>/measurement_log/get",
            success: function(result) {
                var data = JSON.parse(result);
                for (var i = 0; i < data.length; i++) {
                    try {
                        // $("#parameter_value_" + data[i].parameter_id).html(data[i].value);
                        $("#parameter_value_" + data[i].parameter_id).html(data[i].avg_value);
                    } catch (ex) {}
                }
            }
        });
        setTimeout(function() {
            reload_measurement_log();
        }, 1000);
    }
    reload_measurement_log();
    reload_graph();
</script>