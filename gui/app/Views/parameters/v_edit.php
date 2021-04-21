<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mx-auto">

                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <div class="card-title"><?= $__modulename ?></div>
                            <div>
                                <a href="#" onclick="return window.history.go(-1);" class="btn btn-sm btn-link">
                                    <i class="fa fa-arrow-left fa-xs"></i> Back
                                </a>
                            </div>
                        </div>

                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" placeholder="Name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Caption</label>
                                                <input type="text" placeholder="Caption" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Instrument</label>
                                        <select name="instrument_id" class="form-control">
                                            <?php foreach ($instruments as $instrument) : ?>
                                                <option value="<?= $instrument->id ?>"><?= $instrument->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <select name="unit_id" class="form-control">
                                            <?php foreach ($units as $unit) : ?>
                                                <option value="<?= $unit->id ?>"><?= $unit->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Labjack Value</label>
                                        <select name="labjack_value_id" class="form-control">
                                            <?php foreach ($labjack_values as $labval) : ?>
                                                <option value="<?= $labval->id ?>">[<?= $labval->code ?>] - AIN<?= $labval->ain_id ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mocular Mass</label>
                                                <input type="text" placeholder="Mocular Mass" class="form-control">
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Formula</label>
                                                <input type="text" placeholder="Formula" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Voltage 1</label>
                                                <input type="text" placeholder="Voltage 1" class="form-control">
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Voltage 2</label>
                                                <input type="text" placeholder="Voltage 2" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Concentration 1</label>
                                                <input type="text" placeholder="Concentration 1" class="form-control">
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Concentration 2</label>
                                                <input type="text" placeholder="Concentration 2" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">View</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="is_view" type="radio" id="showed" value="1">
                                                    <label class="form-check-label text-success" for="showed">Showed</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="is_view" type="radio" id="hidden" value="0">
                                                    <label class="form-check-label text-danger" for="hidden">Hidden</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="d-block">Graph</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="is_graph" type="radio" id="showed" value="1">
                                                    <label class="form-check-label text-success" for="showed">Showed</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" name="is_graph" type="radio" id="hidden" value="0">
                                                    <label class="form-check-label text-danger" for="hidden">Hidden</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button name="Save" type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>