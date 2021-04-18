<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input name="name" type="text" class="form-control" placeholder="Name ..." value="<?= @$group->name; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4><b>Privileges : </b></h4>
                            <?php foreach ($main_menus as $main_menu) : ?>
                                <div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>
                                                    <input id="main_menu[<?= $main_menu->id; ?>]" name="main_menu[<?= $main_menu->id; ?>]" value="1" type="checkbox" onchange="change_mainmenu(this);" <?= (in_array($main_menu->id, @$menu_ids)) ? "checked" : ""; ?>> <?= $main_menu->name; ?>
                                                </label>
                                            </div>
                                        </div>
                                        <?php if ($main_menu->url != "#") : ?>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <label>
                                                        <input id="priv_a[<?= $main_menu->id; ?>]" name="priv_a[<?= $main_menu->id; ?>]" value="1" type="checkbox" <?= (@$privileges[$main_menu->id] & 1) ? "checked" : ""; ?>> Add
                                                        &nbsp;&nbsp;&nbsp;<input id="priv_e[<?= $main_menu->id; ?>]" name="priv_e[<?= $main_menu->id; ?>]" value="2" type="checkbox" <?= (@$privileges[$main_menu->id] & 2) ? "checked" : ""; ?>> Edit
                                                        &nbsp;&nbsp;&nbsp;<input id="priv_v[<?= $main_menu->id; ?>]" name="priv_v[<?= $main_menu->id; ?>]" value="4" type="checkbox" <?= (@$privileges[$main_menu->id] & 4) ? "checked" : ""; ?>> View
                                                        &nbsp;&nbsp;&nbsp;<input id="priv_d[<?= $main_menu->id; ?>]" name="priv_d[<?= $main_menu->id; ?>]" value="8" type="checkbox" <?= (@$privileges[$main_menu->id] & 8) ? "checked" : ""; ?>> Delete
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                    <?php foreach ($menu_details[$main_menu->id] as $menu_detail) : ?>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="menu_detail[<?= $menu_detail->id; ?>]" name="menu_detail[<?= $menu_detail->id; ?>]" value="1" type="checkbox" onchange="change_menu_detail(this);" <?= (in_array($menu_detail->id, @$menu_ids)) ? "checked" : ""; ?>> <?= $menu_detail->name; ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <label>
                                                        <input id="priv_a[<?= $menu_detail->id; ?>]" name="priv_a[<?= $menu_detail->id; ?>]" value="1" type="checkbox" <?= (@$privileges[$menu_detail->id] & 1) ? "checked" : ""; ?>> Add
                                                        &nbsp;&nbsp;&nbsp;<input id="priv_e[<?= $menu_detail->id; ?>]" name="priv_e[<?= $menu_detail->id; ?>]" value="2" type="checkbox" <?= (@$privileges[$menu_detail->id] & 2) ? "checked" : ""; ?>> Edit
                                                        &nbsp;&nbsp;&nbsp;<input id="priv_v[<?= $menu_detail->id; ?>]" name="priv_v[<?= $menu_detail->id; ?>]" value="4" type="checkbox" <?= (@$privileges[$menu_detail->id] & 4) ? "checked" : ""; ?>> View
                                                        &nbsp;&nbsp;&nbsp;<input id="priv_d[<?= $menu_detail->id; ?>]" name="priv_d[<?= $menu_detail->id; ?>]" value="8" type="checkbox" <?= (@$privileges[$menu_detail->id] & 8) ? "checked" : ""; ?>> Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/groups" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>