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
                                <a href="/parameters" class="btn btn-sm btn-link">
                                    <i class="fa fa-arrow-left fa-xs"></i> Back
                                </a>
                            </div>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" value="<?= old('name', @$parameter->name) ?>" placeholder="Name" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('name') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Caption</label>
                                        <input type="text" name="caption" value="<?= old('caption', @$parameter->caption) ?>" placeholder="Caption" class="form-control <?= $validation->hasError('caption') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('caption') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Stack</label>
                                                <select name="stack_id" class="form-control <?= $validation->hasError('stack_id') ? 'is-invalid' : '' ?>">
                                                    <option value="" selected disabled>Select Stack</option>
                                                    <?php foreach ($stacks as $stack) : ?>
                                                        <option value="<?= $stack->id ?>" <?= $stack->id == old('stack_id', @$parameter->stack_id) ? 'selected' : null ?>><?= $stack->code ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Instrument</label>
                                                <select name="instrument_id" class="form-control <?= $validation->hasError('instrument_id') ? 'is-invalid' : '' ?>">
                                                    <option value="" selected disabled>Select Instrument</option>
                                                    <?php foreach ($instruments as $instrument) : ?>
                                                        <option value="<?= $instrument->id ?>" <?= $instrument->id == old('instrument_id', @$parameter->instrument_id) ? 'selected' : null ?>><?= $instrument->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('instrument_id') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status_id" class="form-control <?= $validation->hasError('status_id') ? 'is-invalid' : '' ?>">
                                                    <option value="" selected disabled>Select Status</option>

                                                    <?php foreach ($statuses as $status) : ?>
                                                        <option value="<?= $status->id ?>" <?= $status->id == old('status_id', @$parameter->status_id) ? 'selected' : null ?>><?= $status->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('status_id') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <select name="unit_id" class="form-control <?= $validation->hasError('unit_id') ? 'is-invalid' : '' ?>">
                                            <option value="" selected disabled>Select Unit</option>

                                            <?php foreach ($units as $unit) : ?>
                                                <option value="<?= $unit->id ?>" <?= $unit->id == old('unit_id', @$parameter->unit_id) ? 'selected' : null ?>><?= $unit->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('unit_id') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group <?= $validation->hasError('is_view') ? 'is-invalid' : '' ?>">
                                        <label class="d-block">View</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="is_view" type="radio" id="showed" value="1" <?= ((int) old('is_view', @$parameter->is_view)) == 1 ? 'checked="checked"' : null ?>">
                                            <label class="form-check-label text-success" for="showed">Showed</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="is_view" type="radio" id="hidden" value="0" <?= ((int) old('is_view', @$parameter->is_view)) == 0 ? 'checked="checked"' : null ?>>
                                            <label class="form-check-label text-danger" for="hidden">Hidden</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('is_view') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group <?= $validation->hasError('is_graph') ? 'is-invalid' : '' ?>">
                                        <label class="d-block">Graph</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="is_graph" type="radio" id="showed-graph" value="1" <?= ((int) old('is_graph', @$parameter->is_graph)) == 1 ? 'checked="checked"' : null ?>>
                                            <label class="form-check-label text-success" for="showed-graph">Showed</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="is_graph" type="radio" id="hidden-graph" value="0" <?= ((int) old('is_graph', @$parameter->is_graph)) == 0 ? 'checked="checked"' : null ?>>
                                            <label class="form-check-label text-danger" for="hidden-graph">Hidden</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('is_graph') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Molecular Mass</label>
                                        <input type="text" name="molecular_mass" value="<?= old('molecular_mass', @$parameter->molecular_mass) ?>" placeholder="Molecular Mass" class="form-control <?= $validation->hasError('molecular_mass') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('molecular_mass') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Parameter Type</label>
                                        <?= $__form->select("p_type", $p_types, @$parameter->p_type); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Labjack Value</label>
                                        <select id="labjack_value_id" name="labjack_value_id" class="form-control <?= $validation->hasError('labjack_value_id') ? 'is-invalid' : '' ?>">
                                            <option value="" selected disabled>Select Labjack Value</option>

                                            <?php foreach ($labjack_values as $labval) : ?>
                                                <option value="<?= $labval->id ?>" <?= $labval->id == old('labjack_value_id', @$parameter->labjack_value_id) ? 'selected' : null ?>>[<?= $labval->code ?>] - AIN<?= $labval->ain_id ?> => $labjack[<?= $labval->labjack_id ?>][<?= $labval->ain_id ?>]</option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('labjack_value_id') ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($_mode == "edit") : ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Current Voltage</label>
                                            <div class="input-group">
                                                <input type="text" id="voltage" class="form-control" readonly>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" onclick="$('#voltage1').val($('#voltage').val());">Set V1</button>
                                                    <button type="button" class="btn btn-info btn-flat" onclick="$('#voltage2').val($('#voltage').val());">Set V2</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Voltage 1</label>
                                        <input type="text" id="voltage1" name="voltage1" value="<?= old('voltage1', @$parameter->voltage1) ?>" placeholder="Voltage 1" class="form-control <?= $validation->hasError('voltage1') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('voltage1') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Voltage 2</label>
                                        <input type="text" id="voltage2" name="voltage2" value="<?= old('voltage2', @$parameter->voltage2) ?>" placeholder="Voltage 2" class="form-control <?= $validation->hasError('voltage2') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('voltage2') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Concentration 1</label>
                                        <input type="text" id="concentration1" name="concentration1" value="<?= old('concentration1', @$parameter->concentration1) ?>" placeholder="Concentration 1" class="form-control <?= $validation->hasError('concentration1') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('concentration1') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Concentration 2</label>
                                        <input type="text" id="concentration2" name="concentration2" value="<?= old('concentration2', @$parameter->concentration2) ?>" placeholder="Concentration 2" class="form-control <?= $validation->hasError('concentration2') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('concentration2') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Formula</label>
                                        <div class="input-group">
                                            <input type="text" id="formula" name="formula" value="<?= old('formula', @$parameter->formula) ?>" placeholder="Formula" class="form-control <?= $validation->hasError('formula') ? 'is-invalid' : '' ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('formula') ?>
                                            </div>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-flat" onclick="generate_formula();">Generate Formula</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button name="Save" type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>