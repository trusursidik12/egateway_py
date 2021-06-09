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
                                        <label>Group</label>
                                        <select name="group_id" class="form-control" disabled>
                                            <option value="">-- Group --</option>
                                            <?php foreach ($groups as $group) : ?>
                                                <option value="<?= $group->id; ?>"><?= $group->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name="email" type="text" class="form-control" placeholder="Email ..." disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input name="password" type="password" class="form-control" placeholder="Password ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input name="name" type="text" class="form-control" placeholder="Name ...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/users" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>