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
                                        <select name="group_id" class="form-control">
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
                                        <input name="email" type="text" class="form-control" placeholder="Email ...">
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Job Title</label>
                                        <input name="job_title" type="text" class="form-control" placeholder="Job Title ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Division</label>
                                        <select name="division_id" class="form-control">
                                            <option value="">-- Division --</option>
                                            <?php foreach ($divisions as $division) : ?>
                                                <option value="<?= $division->id; ?>"><?= $division->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Leader</label>
                                        <select name="leader_user_id" class="form-control">
                                            <option value="">-- Leader --</option>
                                            <?php foreach ($users as $_user) : ?>
                                                <option value="<?= $_user->id; ?>"><?= $_user->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if ($__mode == "edit") : ?>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>User Signature</label>
                                            <input name="user_signature" type="file" class="form-control" placeholder="User Signature ...">
                                            <?php if (file_exists("dist/upload/users_signature/" . $user->signature) && $user->signature != "") : ?>
                                                <img src="<?= base_url(); ?>/dist/upload/users_signature/<?= $user->signature; ?>" height="150">
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>User Photo</label>
                                            <input name="user_photo" type="file" class="form-control" placeholder="User Photo ...">
                                            <?php if (file_exists("dist/upload/users_photo/" . $user->photo) && $user->photo != "") : ?>
                                                <img src="<?= base_url(); ?>/dist/upload/users_photo/<?= $user->photo; ?>" height="150">
                                            <?php endif ?>
                                        </div>
                                    </div>
                                <?php endif ?>
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