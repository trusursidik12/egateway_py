<script>
    <?php if (isset($user)) : ?>
        $("[name='group_id']").val("<?= $user->group_id; ?>");
        $("[name='email']").val("<?= $user->email; ?>");
        $("[name='name']").val("<?= $user->name; ?>");
    <?php endif ?>
</script>