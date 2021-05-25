<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mx-auto">

                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <div class="card-title"><?= $__modulename ?></div>
                            <div>
                                <a href="/stacks" class="btn btn-sm btn-link">
                                    <i class="fa fa-arrow-left fa-xs"></i> Back
                                </a>
                            </div>
                        </div>

                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Stack Code</label>
                                <input type="text" name="code" value="<?= old('code', @$stack->code) ?>" placeholder="Stack Code" class="form-control <?= $validation->hasError('code') ? 'is-invalid' : '' ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('code') ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Height</label>
                                        <input type="text" name="height" value="<?= old('height', @$stack->height) ?>" placeholder="Stack height" class="form-control <?= $validation->hasError('height') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('height') ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Diameter</label>
                                        <input type="text" name="diameter" value="<?= old('diameter', @$stack->diameter) ?>" placeholder="Stack diameter" class="form-control <?= $validation->hasError('diameter') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('diameter') ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Flow</label>
                                        <input type="text" name="flow" value="<?= old('flow', @$stack->flow) ?>" placeholder="Stack flow" class="form-control <?= $validation->hasError('flow') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('flow') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Longitude</label>
                                        <input type="text" name="lon" value="<?= old('lon', @$stack->lon) ?>" placeholder="Longitude" class="form-control <?= $validation->hasError('lon') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('lon') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Latitude</label>
                                        <input type="text" name="lat" value="<?= old('lat', @$stack->lat) ?>" placeholder="Latitude" class="form-control <?= $validation->hasError('lat') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('lat') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Oxygen Reference (%)</label>
                                        <input type="text" name="oxygen_reference" value="<?= old('oxygen_reference', @$stack->oxygen_reference) ?>" placeholder="Oxygen Reference (%)" class="form-control <?= $validation->hasError('oxygen_reference') ? 'is-invalid' : '' ?>">
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