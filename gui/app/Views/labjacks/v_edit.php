<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Labjack Code *</label>
                                        <input type="hidden" name="id" value="<?= @$labjack->id ?>">
                                        <input name="labjack_code" type="text" class="form-control <?= $validation->hasError('labjack_code') ? 'is-invalid' : '' ?>" placeholder="Labjack Code .. *" value="<?= empty(@$labjack->labjack_code) ? old('labjack_code') : @$labjack->labjack_code ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('labjack_code') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Instruent *</label>
                                        <select name="instrument_id" class="form-control <?= $validation->hasError('instrument_id') ? 'is-invalid' : '' ?>">
                                            <option value="">-- Select -- *</option>
                                            <?php foreach ($instruments as $instrument) : ?>
                                                <option value="<?= $instrument->id ?>" <?php if (empty(@$labjack->instrument_id)) : ?> <?= old('instrument_id') == $instrument->id ? 'selected' : '' ?> <?php else : ?> <?= @$labjack->instrument_id == $instrument->id ? 'selected' : '' ?> <?php endif ?>><?= $instrument->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('instrument_id') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="/labjacks" class="btn btn-info"><i class="fas fa-back mr-2"></i>Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>