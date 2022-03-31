<script>
    $(document).ready(function(){
        let table = $('#dis-history-table').DataTable({
            "language": {
                "emptyTable": "You must filter data by Parameter , Date Start, & Date End"
            },
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "pageLength": 2,
            // "serverMethod": "post",
            "ajax": {
                "url": "<?= base_url('/dis-history-data/list') ?>",
                "data": function(data) {
                    data.parameter_id = $('#parameter_id').val();
                    data.date_start = $('#date_start').val();
                    data.date_end = $('#date_end').val();
                }
            },
            lengthMenu: [
                [2, 50, 100, -1],
                [2, 50, 100, "All"]
            ],
            dom: '<"dt-buttons"Bf><"clear">lirtp',
            buttons: [{
                text: 'Export to Excel',
                extend: 'excel',
                className: 'btn btn-sm btn-success mb-3',
            }],
            columns : [{
                render : function(data,type,row){
                    let date = new Date(row.Timestamp);
                    let formated = date.toLocaleDateString('id',{ weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

                    return `${formated} Pkl ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
                },
                data : 'Timestamp'
            },{
                data : 'Parameter'
            },{
                data : 'Value'
            }]
        })
        $('.dt-buttons > button').removeClass('dt-button buttons-excel buttons-html5');
        $('#btn-filter').click(function(){
            table.draw();
        })
    });
</script>