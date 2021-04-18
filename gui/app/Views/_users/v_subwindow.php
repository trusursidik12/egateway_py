<div class="card-body table-responsive p-0">
    <table id="subwindow" class="table table-head-fixed text-nowrap table-striped" width="100%">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    $(document).ready(function() {

        dataTable = $('#subwindow').DataTable({
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,
            'serverMethod': 'post',
            "ajax": {
                "url": "<?= base_url() ?>/a_user/get_users/select/<?= $id ?>",
                'data': function(data) {
                    data.keyword = "<?= $q; ?>";
                }
            }
        });
    });
</script>