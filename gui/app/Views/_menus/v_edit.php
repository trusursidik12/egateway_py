<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Parent Menu</label>
                                        <select name="parent_id" class="form-control">
                                            <option value="">-- Parent Menu --</option>
                                            <?php foreach ($parents as $parent) : ?>
                                                <option value="<?= $parent->id; ?>"><?= $parent->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input name="name" type="text" class="form-control" placeholder="Name ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Url</label>
                                        <input name="url" type="text" class="form-control" placeholder="Url ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Icon</label>
                                        <input name="icon" type="text" class="form-control" placeholder="Icon ...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($__mode == "add") : ?>
                            <div class="card-body">
                                <h4><b>Groups</b></h4>
                                <?php foreach ($groups as $group) : ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <input id="group[<?= $group->id; ?>]" name="group[<?= $group->id; ?>]" value="1" type="checkbox" onchange="change_group(this);" checked> <?= $group->name; ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                &nbsp;&nbsp;&nbsp;<input id="priv_a[<?= $group->id; ?>]" name="priv_a[<?= $group->id; ?>]" value="1" type="checkbox" checked> Add
                                                &nbsp;&nbsp;&nbsp;<input id="priv_e[<?= $group->id; ?>]" name="priv_e[<?= $group->id; ?>]" value="2" type="checkbox" checked> Edit
                                                &nbsp;&nbsp;&nbsp;<input id="priv_v[<?= $group->id; ?>]" name="priv_v[<?= $group->id; ?>]" value="4" type="checkbox" checked> View
                                                &nbsp;&nbsp;&nbsp;<input id="priv_d[<?= $group->id; ?>]" name="priv_d[<?= $group->id; ?>]" value="8" type="checkbox" checked> Delete
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/menu" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>