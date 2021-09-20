<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-2">
                        <a href="/backup/backup_exec" class="btn btn-primary"><i class="fas fa-plus"></i> New Backup</a>
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
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <form role="form" method="POST" enctype="multipart/form-data" action="backup/restore_exec">
                    <div class="card">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>File Backup to Restore</label>
                                    <input name="filename" type="file" class="form-control" placeholder="Filename ...">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" name="Restore" value="Restore" class="btn btn-primary float-right">Restore</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>