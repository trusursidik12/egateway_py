<script>
    $(document).ready(function() {
        $('.btn-delete').click(function() {
            let id = $(this).attr('data-id');
            function_delete(id, '<?= base_url('stack/delete') ?>');
        })
    });
</script>
<script>
    $(document).ready(function() {
        $("select[name='parameter_id[]']").select2();
        $('table').DataTable({
            'fnDrawCallback': function(oSettings) {
                get_param();
            }
        });
    })
</script>