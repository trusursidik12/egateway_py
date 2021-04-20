<script>
    function reload_measurement_log() {
        $.ajax({
            url: "http://localhost:8080/measurement_log/get",
            success: function(result) {
                var data = JSON.parse(result);
                for (var i = 0; i < data.length; i++) {
                    try {
                        $("#parameter_value_" + data[i].parameter_id).html(data[i].value);
                    } catch (ex) {}
                }
            }
        });
        setTimeout(function() {
            reload_measurement_log()
        }, 1000);
    }
    reload_measurement_log();
</script>