<script>
    <?php if (isset($user)) : ?>
        $("[name='group_id']").val("<?= $user->group_id; ?>");
        $("[name='email']").val("<?= $user->email; ?>");
        $("[name='name']").val("<?= $user->name; ?>");
        $("[name='job_title']").val("<?= $user->job_title; ?>");
        $("[name='division_id']").val("<?= $user->division_id; ?>");
        $("[name='leader_user_id']").val("<?= $user->leader_user_id; ?>");
    <?php endif ?>
</script>