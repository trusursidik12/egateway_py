<script>
    $('table').DataTable({
        'fnDrawCallback': function(oSettings) {}
    });
</script>
<script>
    $(document).ready(function() {
        $('.btn-delete').click(function() {
            let id = $(this).attr('data-id');
            function_delete(id, '<?= base_url('configuration/delete') ?>');
        })
    });
</script>