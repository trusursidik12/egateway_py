<script>
    $(document).ready(function() {
        dataTable = $('#measurementList').DataTable({
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "pageLength": 50,
            "serverMethod": "post",
            "ajax": {
                "url": "<?= base_url('/measurement/list') ?>",
                "data": function(data) {
                    data.instrument_id = $('#instrument_id').val();
                    data.instrument_status_id = $('#instrument_status_id').val();
                    data.data_status_id = $('#data_status_id').val();
                    data.measured_at = $('#measured_at').val();
                }
            },
        })
    })
</script>