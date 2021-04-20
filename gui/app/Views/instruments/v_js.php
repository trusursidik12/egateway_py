<script>
    $("select[name='parameter_id[]']").select2();
    $('table').DataTable({

    });
</script>
<script>
    try {
        $('.instrument_id').map((idx, el) => {
            let id = parseInt(el.innerHTML); /* Get ID */
            let parameters = el.parentNode.querySelector('.parameters');
            $.ajax({
                url: '/instrument/get_parameter/' + id,
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
</script>