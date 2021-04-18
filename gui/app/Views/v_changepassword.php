<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <form method="post">
                <input type="hidden" name="changepassword" value="1">
                <div class="form-group">
                    <label for="old_password">Old Password</label>
                    <input type="password" name="old_password" class="form-control" placeholder="Old Password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="New Password" Xpattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                </div>
                <div class="form-group">
                    <label for="retype_password">Retype New Password</label>
                    <input type="password" name="retype_password" class="form-control" placeholder="Retype New Password" required>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>