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
                    <div class="card-body table-responsive p-0" style="height: 700px;">
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
            </div>
        </div>
    </div>
</div>