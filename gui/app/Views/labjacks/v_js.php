<script>
    $(document).ready(function() {
        $('.btn-delete').click(function() {
            let id = $(this).attr('data-id');
            function_delete(id, '<?= base_url('process/labjack/delete') ?>');
        })
    });
</script>