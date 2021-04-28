<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <div class="card-title"></div>
                            <div>
                                <a href="#" onclick="return window.history.go(-1);" class="btn btn-sm btn-link">
                                    <i class="fa fa-arrow-left fa-xs"></i> Back
                                </a>
                            </div>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Labjack</label>
                                    <select id="labjack_id" name="labjack_id" class="form-control">
                                        <option value="" selected>Select Labjack</option>
                                        <?php foreach ($labjacks as $labjack) : ?>
                                            <option value="<?= $labjack->id ?>">[<?= $labjack->id ?>] - <?= $labjack->labjack_code ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <?php for ($i = 0; $i < 4; $i++) : ?>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="h3">AIN <?= $i ?></p>
                                                <span>
                                                    <p class="h1 d-inline" id="AIN_<?= $i; ?>"></p>
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                <?php endfor ?>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function reload_voltages() {
        if ($("#labjack_id").val()) {
            $.get("<?= base_url(); ?>/labjack_value/get_voltages_by_labjack_id/" + $("#labjack_id").val(), function(labjack_values) {
                labjack_values = JSON.parse(labjack_values);
                for (var i = 0; i < labjack_values.length; i++) {
                    $("#AIN_" + labjack_values[i].ain_id).html(labjack_values[i].data);
                }
            });
        } else {
            for (var i = 0; i < 4; i++) {
                $("#AIN_" + i).html(0);
            }
        }

        setTimeout(function() {
            reload_voltages();
        }, 1000);
    }
</script>