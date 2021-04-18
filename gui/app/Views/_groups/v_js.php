<script>

    function change_mainmenu(elm){
        var idx = elm.id.replace("main_menu[","").replace("]","");
        try{
            document.getElementById("priv_a[" + idx + "]").checked = elm.checked;
            document.getElementById("priv_e[" + idx + "]").checked = elm.checked;
            document.getElementById("priv_v[" + idx + "]").checked = elm.checked;
            document.getElementById("priv_d[" + idx + "]").checked = elm.checked;
        } catch (ex){}

        $(elm.parentElement.parentElement.parentElement.parentElement.parentElement.childNodes).find(':checkbox').each(function() {
            $( this ).prop('checked', elm.checked);
        });
    }

    function change_menu_detail(elm){
        var idx = elm.id.replace("menu_detail[","").replace("]","");
        document.getElementById("priv_a[" + idx + "]").checked = elm.checked;
        document.getElementById("priv_e[" + idx + "]").checked = elm.checked;
        document.getElementById("priv_v[" + idx + "]").checked = elm.checked;
        document.getElementById("priv_d[" + idx + "]").checked = elm.checked;
    }
</script>