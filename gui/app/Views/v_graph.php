<link rel="stylesheet" href="<?= base_url(); ?>/dist/css/morris.css">
<script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/dist/js/raphael-min.js"></script>
<script src="<?= base_url(); ?>/dist/js/morris.min.js"></script>
<script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>/dist/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">
    var chart = Morris.Line({
        element: 'graph',
        data: [<?= $graph_data; ?>],
        xkey: 'time',
        ykeys: [<?= $graph_fields; ?>],
        labels: [<?= $graph_fields; ?>],
        resize: true
    });
</script>