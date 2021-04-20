<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">

                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">Instrument List</div>
                            <div>
                                <a href="/instrument/add" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus fa-xs"></i> Add Instrument
                                </a>
                            </div>
                        </div>

                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-stripped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Parameter</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td>Name <?= $i ?></td>
                                            <td>Type <?= $i ?></td>
                                            <td>Parameter <?= $i ?></td>
                                            <td>Status <?= $i ?></td>
                                            <td>Created By <?= $i ?></td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>