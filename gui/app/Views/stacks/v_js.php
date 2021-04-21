<script>
    $("select[name='parameter_id[]']").select2();
    $('table').DataTable({
        'fnDrawCallback': function(oSettings) {
            get_param();
        }
    });
</script>
<script>
    let get_param = () => {
        try {
            $('.stack_id').map((idx, el) => {
                let id = parseInt(el.innerHTML); /* Get ID */
                let parameters = el.parentNode.querySelector('.params');
                $.ajax({
                    url: '/stack/get_parameter/' + id,
                    dataType: 'json',
                    success: function(data) {
                        if (data !== null) {
                            let html = `<ul>`;
                            data.map((response, index) => {
                                console.log(response);
                                html += `<li>` + response.name + `</li>`;
                            });
                            html += `</ul>`;
                            parameters.innerHTML = html;
                        } else {
                            parameters.innerHTML = `Cant get parameter value`;
                        }
                    }
                })
            })

        } catch (err) {
            console.error(err);
        }
    }
    get_param();
</script>
<script>
    $(document).ready(function() {
        $('.btn-delete').click(function() {
            let id = $(this).attr('data-id');
            function_delete(id, '<?= base_url('instrument/delete') ?>');
        })
    });
</script>