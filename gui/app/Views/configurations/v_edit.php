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
                                <a href="/configurations" class="btn btn-sm btn-link">
                                    <i class="fa fa-arrow-left fa-xs"></i> Back
                                </a>
                            </div>
                        </div>

                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>eGateway Code</label>
                                        <input type="text" name="egateway_code" value="<?= old('egateway_code', @$configuration->egateway_code) ?>" placeholder="eGateway Code" class="form-control <?= $validation->hasError('egateway_code') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('egateway_code') ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <input type="text" name="customer_name" value="<?= old('customer_name', @$configuration->customer_name) ?>" placeholder="Customer Name" class="form-control <?= $validation->hasError('customer_name') ? 'is-invalid' : '' ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('customer_name') ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" placeholder="Full Address" rows="2" class="form-control <?= $validation->hasError('address') ? 'is-invalid' : '' ?>"><?= old('address', @$configuration->address) ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('address') ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" name="city" value="<?= old('city', @$configuration->city) ?>" placeholder="City" class="form-control <?= $validation->hasError('city') ? 'is-invalid' : '' ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('city') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Province</label>
                                                <input type="text" name="province" value="<?= old('province', @$configuration->province) ?>" placeholder="Province" class="form-control <?= $validation->hasError('province') ? 'is-invalid' : '' ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('province') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Longitude</label>
                                                <input type="text" name="lon" value="<?= old('lon', @$configuration->lon) ?>" placeholder="Longitude" class="form-control <?= $validation->hasError('lon') ? 'is-invalid' : '' ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('lon') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Latitude</label>
                                                <input type="text" name="lat" value="<?= old('lat', @$configuration->lat) ?>" placeholder="Latitude" class="form-control <?= $validation->hasError('lat') ? 'is-invalid' : '' ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('lat') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Interval Das Logs (Minute(s))</label>
                                                <input type="text" name="interval_das_logs" value="<?= old('interval_das_logs', @$configuration->interval_das_logs) ?>" placeholder="Interval DAS Logs" class="form-control <?= $validation->hasError('interval_das_logs') ? 'is-invalid' : '' ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('interval_das_logs') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Interval Average (Minute(s))</label>
                                                <input type="text" name="interval_average" value="<?= old('interval_average', @$configuration->interval_average) ?>" placeholder="Interval Average" class="form-control <?= $validation->hasError('interval_average') ? 'is-invalid' : '' ?>">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('interval_average') ?>
                                                </div>
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