<script>
    let get_param = () => {
        try {
            $('.instrument_id').map((idx, el) => {
                let id = parseInt(el.innerHTML); /* Get ID */
                let parameters = el.parentNode.querySelector('.parameters');
                $.ajax({
                    url: '/instrument/get_parameter/' + id,
                    dataType: 'json',
                    success: function(data) {
                        if (data !== null) {
                            let html = `<div class='d-inline'>`;
                            data.map((response, index) => {
                                if (response?.name != undefined) {
                                    html += `<span class='mx-1 badge badge-info'>` + response.name + `</span>`;
                                }
                            });
                            html += `</div>`;
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
        });
        try {
            $("select[name='parameter_id[]']").select2();
            $('table').DataTable({
                'fnDrawCallback': function(oSettings) {
                    get_param();
                }
            });
        } catch (err) {
            console.error(err);
        }
    });
</script>