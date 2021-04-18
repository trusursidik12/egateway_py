<script>
    <?php if (isset($menu)) : ?>
        $("[name='parent_id']").val("<?= $menu->parent_id; ?>");
        $("[name='name']").val("<?= $menu->name; ?>");
        $("[name='url']").val("<?= $menu->url; ?>");
        $("[name='icon']").val("<?= $menu->icon; ?>");
    <?php endif ?>

    function change_group(elm) {
        var idx = elm.id.replace("group[", "").replace("]", "");
        document.getElementById("priv_a[" + idx + "]").checked = elm.checked;
        document.getElementById("priv_e[" + idx + "]").checked = elm.checked;
        document.getElementById("priv_v[" + idx + "]").checked = elm.checked;
        document.getElementById("priv_d[" + idx + "]").checked = elm.checked;
    }
</script>