<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>
<script>
    $(document).ready(function() {
        try {
            $('table').DataTable();
        } catch (err) {
            console.log(err);
        }

        // Edit Page
        try {

            $('#form-edit').submit(function(e) {
                e.preventDefault();
                let button = $(this).find('button[type=submit]');
                let htmlBtn = button.html();
                button.attr('disabled', true);
                button.html(`Loading <i class="fas fa-spin fa-spinner"></i>`);
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if (data?.success) {
                            button.html(htmlBtn);
                            button.attr('disabled', false);
                            return Toast.fire({
                                type: 'success',
                                title: data?.message
                            });
                        }
                        return Toast.fire({
                            type: 'error',
                            title: data?.message
                        });
                    },
                    error: function(xhr, status, err) {
                        button.html(htmlBtn);
                        button.attr('disabled', false);
                        return Toast.fire({
                            type: 'error',
                            title: err
                        });
                    }
                })
            })
        } catch (err) {

        }
    });
</script>