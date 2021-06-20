<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-2">
                        <a href="/labjack/add" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body table-responsive p-0" style="height: 700px;">
                        <table class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Labjack Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>
                                <?php foreach ($labjacks as $labjack) : ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="/labjack/edit/<?= $labjack->id ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button data-id="<?= $labjack->id ?>" class="btn-delete text-white btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td><?= $no++ ?></td>
                                        <td><?= @$labjack->labjack_code; ?></td>
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