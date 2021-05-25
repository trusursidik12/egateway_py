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
                                <a href="/instruments" class="btn btn-sm btn-link">
                                    <i class="fa fa-arrow-left fa-xs"></i> Back
                                </a>
                            </div>
                        </div>

                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <?php if (isset($errors)) : ?>
                            <?php foreach ($errors as $error) : ?>
                                <p class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= esc($error) ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Instrument Name</label>
                                <input type="text" name="name" value="<?= old('name', @$instrument->name) ?>" placeholder="Instrument Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Stack</label>
                                <select name="stack_id" class="form-control">
                                    <option value="">Select Stack</option>
                                    <?php foreach ($stacks as $stack) : ?>
                                        <option value="<?= $stack->id ?>" <?= old('stack_id', @$instrument->stack_id) == $stack->id ? 'selected' : null ?>><?= $stack->code ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Parameter</label>
                                <select name="parameter_id[]" class="form-control" multiple>
                                    <option value="" disabled>Select Parameter</option>
                                    <?php foreach ($parameters as $parameter) : ?>
                                        <option value="<?= $parameter->id ?>" <?= array_search($parameter->id, (old('parameter_id', @$parameter_ids) === null ? [] : $parameter_ids)) !== false ? 'selected' : null ?>><?= $parameter->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=" form-group">
                                <label>Type Instrument</label>
                                <select name="i_type" class="form-control">
                                    <option value="">Select Type Instrument</option>
                                    <option value="CEMS" <?= @$instrument->i_type == "CEMS" ? 'selected' : null ?>>CEMS</option>
                                    <option value="AQMS" <?= @$instrument->i_type == "AQMS" ? 'selected' : null ?>>AQMS</option>
                                    <option value="ISPUTEN" <?= @$instrument->i_type == "ISPUTEN" ? 'selected' : null ?>>ISPUTEN</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status_id" class="form-control">
                                    <option value="">Select Status</option>
                                    <?php foreach ($statuses as $status) : ?>
                                        <option value="<?= $status->id ?>" <?= $status->id == old('status_id', @$instrument->status_id) ? 'selected' : null ?>><?= $status->name ?></option>
                                    <?php endforeach; ?>
                                </select>
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