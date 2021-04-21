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
                                    <th>Instrument</th>
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
                                        <td><?= $labjack->labjack_code; ?></td>
                                        <td><?= $labjack->instrument_id ?></td>
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

<!-- <div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/process/labjack/delete" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="iddelete" id="iddelete">
                    <p>Are you sure want to delete this data ?&hellip;</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div> -->