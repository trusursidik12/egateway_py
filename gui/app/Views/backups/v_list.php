<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-2">
                        <a href="#" onclick="newbackup();" class="btn btn-primary"><i class="fas fa-plus"></i> New Backup</a>
                    </div>
                    <div id="backup_spinner" style="display:none;" class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body table-responsive py-5">
                        <table class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Filename</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>
                                <?php foreach ($backups as $backup) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><a target="_BLANK" href="dist/upload/backups/<?= $backup; ?>"><?= $backup; ?></a></td>
                                    </tr>
                                    <?php if ($no > 100) break; ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <form role="form" method="POST" enctype="multipart/form-data" action="restore_exec">
                    <div class="card">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Backup File to Restore</label>
                                    <input id="filename" name="filename" type="file" class="form-control" placeholder="Filename ..." required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="restore_spinner" style="display:none;" class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <button type="submit" name="Restore" onclick="restoring()" value="Restore" class="btn btn-primary float-right">Restore</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function newbackup() {
        document.getElementById("backup_spinner").style.display = "block";
        window.location = "/backup/backup_exec";
    }

    function restoring() {
        if (filename.value != "") {
            document.getElementById("restore_spinner").style.display = "block";
            return true;
        } else {
            return false;
        }
    }
</script>