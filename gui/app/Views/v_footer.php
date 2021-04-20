</div>
<footer class="main-footer d-print-none">
    <strong>Copyright &copy; <?= date("Y"); ?> <a href="https://trusur.com">PT. Trusur Unggul Teknusa</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0
    </div>
</footer>

</div>
<!-- ./wrapper -->

<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content" id="modal_type">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_message">
            </div>
            <div class="modal-footer justify-content-between">
                <a id="modal_ok_link" type="button" class="btn btn-outline-light" href="">OK</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/jszip.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/buttons.flash.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>

<!-- jQuery -->
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url(); ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="<?= base_url(); ?>/dist/js/currencyformatter.js"></script>
<script src="<?= base_url(); ?>/dist/js/bootstrap-multiselect.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= base_url(); ?>/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url(); ?>/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?= base_url(); ?>/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?= base_url(); ?>/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url(); ?>/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url(); ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url(); ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= base_url(); ?>/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url(); ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url(); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url(); ?>/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?= base_url(); ?>/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?= base_url(); ?>/dist/js/demo.js"></script> -->
<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        <?php if (isset($_SESSION["flash_message"][1]) && $_SESSION["flash_message"][1] != "") : ?>
            Toast.fire({
                type: '<?= $_SESSION["flash_message"][0]; ?>',
                title: '<?= $_SESSION["flash_message"][1]; ?>'
            });
        <?php endif ?>
    });
</script>
<script>
    let cleanNumber = (value) => {
        value = value.toString();
        value = value.replace(/,/g, '');
        value = value.replace(/[^\d.-]/g, '');
        return parseFloat(value);
    }
    formatNumber = (angka) => {
        angka = cleanNumber(angka);
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ',';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    }
    $(document).delegate('input[data="amount"]', 'keyup', function() {
        let value = !isNaN(cleanNumber($(this).val())) ? $(this).val() : '0';
        $(this).val(formatNumber(value));
    });

    function view_noification(id) {
        $.ajax({
            url: "<?= base_url(); ?>/notification/get_notification/" + id,
            success: function(result) {
                var notification = JSON.parse(result);
                if (notification.icon == "") notification.icon = "far fa-bell";
                $('#modal_title').html("<i class='" + notification.icon + "'></i> " + 'Notification');
                $('#modal_message').html(notification.message);
                $('#modal_type').attr("class", 'modal-content');
                $('#modal-form').modal();
                $.ajax({
                    url: "<?= base_url(); ?>/notification/set_notification_read/" + notification.id,
                    success: function(result2) {
                        load_notifications();
                    }
                });
            }
        });
    }

    function load_notifications() {
        $.ajax({
            url: "<?= base_url(); ?>/notification/get_notifications/0",
            success: function(result) {
                var notifications = JSON.parse(result);
                var notifications_length = notifications.count;
                notifications = notifications.data;
                var notification_details = "";
                if (notifications_length > 0) {
                    $("#notifications_count").removeClass('d-none');
                    blink_notifications();
                    $("#notifications_count").html(notifications_length);

                    notification_details += "<span class=\"dropdown-item dropdown-header\">" + notifications_length + " Notification";
                    if (notifications_length == 1) notification_details += "</span>";
                    else notification_details += "s</span>";

                    for (var i = 0; i < notifications.length; i++) {
                        notification_details += "<div class=\"dropdown-divider\"></div>";
                        notification_details += "<a href=\"javascript:view_noification(" + notifications[i].id + ");\" class=\"dropdown-item\">";
                        if (notifications[i].icon == "" || notifications[i].icon == undefined)
                            notification_details += "<i class=\"far fa-bell\"></i> ";
                        else
                            notification_details += "<i class=\"" + notifications[i].icon + "\"></i> ";
                        notification_details += notifications[i].message.substring(0, 15) + " ...";
                        notification_details += "    <span class=\"float-right text-muted text-sm\">Read More ..</span>";
                        notification_details += "</a>";
                    }
                } else {
                    $("#notifications_count").html("");
                    $("#notifications_count").addClass('d-none');
                    $("#notification_details").html("");
                }
                notification_details += "<div class=\"dropdown-divider\"></div>";
                notification_details += "<a href=\"<?= base_url(); ?>/notifications\" class=\"dropdown-item dropdown-footer\">See All Notifications</a>";
                $("#notification_details").html(notification_details);
            }
        });
        setTimeout(function() {
            load_notifications();
        }, 60000);
    }
    load_notifications();

    function blink_notifications() {
        $('#notifications_count').fadeOut(200).fadeIn(200, blink_notifications);
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
<!-- </body></html> -->


<script>
    $(document).ready(function() {
        $(document).on('click', '#getiddelete', function() {
            $('#iddelete').val($(this).data('iddelete'));
        })
    });
</script>
</body>

</html>