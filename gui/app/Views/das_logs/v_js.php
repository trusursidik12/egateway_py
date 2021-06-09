<script>
    $(document).ready(function() {
        dataTable = $('#das_logList').DataTable({
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "pageLength": 50,
            "serverMethod": "post",
            "ajax": {
                "url": "<?= base_url('/das_log/list') ?>",
                "data": function(data) {
                    data.instrument_id = $('#instrument_id').val();
                    data.instrument_status_id = $('#instrument_status_id').val();
                    data.data_status_id = $('#data_status_id').val();
                    data.is_sent_cloud = $('#is_sent_cloud').val();
                    data.is_sent_klhk = $('#is_sent_klhk').val();
                    data.measured_at = $('#measured_at').val();
                }
            },
        })
    })
</script>