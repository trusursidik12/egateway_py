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
                                        <th></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Parameter</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($instruments as $instrument) : ?>
                                        <tr>
                                            <td>
                                                <a href="/instrument/edit/<?= $instrument->id ?>" title="Edit" class="btn btn-sm btn-info">
                                                    <i class="fa fa-xs fa-pen"></i>
                                                </a>
                                                <button data-id='<?= $instrument->id ?>' type="button" class="btn-delete btn btn-sm btn-danger" title="Delete">
                                                    <i class="fa fa-xs fa-trash"></i>
                                                </button>
                                            </td>
                                            <td class="instrument_id"><?= $instrument->id ?></td>
                                            <td><?= $instrument->name ?></td>
                                            <td><?= $instrument->i_type ?></td>
                                            <td class="parameters">
                                                <i class="fas fa-spin fa-spinner"></i>
                                            </td>
                                            <td><?= $instrument->status ?></td>
                                            <td><?= $instrument->created_by ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>