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
                                        <input name="name" type="text" class="form-control" placeholder="Name ..." value="<?= @$specific_privilege->name; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Denied Message</label>
                                        <input name="denied_message" type="text" class="form-control" placeholder="Denied Message ..." value="<?= @$specific_privilege->denied_message; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4><b>Users : </b></h4>
                            <?php foreach ($users as $user) : ?>
                                <div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>
                                                    <input id="users[<?= $user->id; ?>]" name="users[<?= $user->id; ?>]" value="1" type="checkbox" <?= (strpos(" " . @$specific_privilege->user_ids, "|" . $user->id . "|") > 0) ? "checked" : ""; ?>> <?= $user->name; ?> (<?= $user->email; ?>)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/specific_privileges" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>