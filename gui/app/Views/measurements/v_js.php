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
                    data.is_sent_cloud = $('#is_sent_cloud').val();
                    data.is_sent_klhk = $('#is_sent_klhk').val();
                    data.date_start = $('#date_start').val();
                    data.date_end = $('#date_end').val();
                }
            },
            lengthMenu: [
                [50, 100, -1],
                [50, 100, "All"]
            ],
            dom: '<"dt-buttons"Bf><"clear">lirtp',
            buttons: [{
                text: 'Export to Excel',
                extend: 'excel',
                className: 'btn btn-sm btn-success mb-3',
            }],
        })
        $('.dt-buttons > button').removeClass('dt-button buttons-excel buttons-html5');
    })
</script>