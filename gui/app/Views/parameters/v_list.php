<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">

                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">Parameter Lists</div>
                            <div>
                                <a href="/parameter/add" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus fa-xs"></i> Add Parameter
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
                                        <th>Instrument</th>
                                        <th>Name</th>
                                        <th>Caption</th>
                                        <th>Unit</th>
                                        <th>Molecular Mass</th>
                                        <th>Formula</th>
                                        <th>View</th>
                                        <th>Graph</th>
                                        <th>Labjack Value</th>
                                        <th>Voltage 1</th>
                                        <th>Voltage 2</th>
                                        <th>Concentration 1</th>
                                        <th>Concentration 2</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($parameters as $param) : ?>
                                        <tr>
                                            <td style="min-width: 60px;">
                                                <a href="<?= base_url("parameter/edit/{$param->id}") ?>" class="btn btn-sm btn-primary" title='Edit'>
                                                    <i class="fa fa-xs fa-pen"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger btn-delete" data-id='<?= @$param->id ?>' title='Delete'>
                                                    <i class="fa fa-xs fa-trash"></i>
                                                </button>
                                            </td>
                                            <td><?= $param->id ?></td>
                                            <td><?= $param->instrument_name ?></td>
                                            <td><?= $param->name ?></td>
                                            <td><?= $param->caption ?></td>
                                            <td><?= $param->unit ?></td>
                                            <td><?= $param->molecular_mass ?></td>
                                            <td><?= $param->formula ?></td>
                                            <td><?=
                                                $param->is_view == 1 ? '<span class="badge badge-success">
                                                                        Showed
                                                                        </span>' : '<span class="badge badge-danger">
                                                                            Hidden
                                                                        </span>'; ?>
                                            </td>
                                            <td><?=
                                                $param->is_graph == 1 ? '<span class="badge badge-success">
                                                                        Showed
                                                                        </span>' : '<span class="badge badge-danger">
                                                                            Hidden
                                                                        </span>'; ?>
                                            </td>
                                            <td><?= $param->labjack_value ?></td>
                                            <td><?= $param->voltage1 ?></td>
                                            <td><?= $param->voltage2 ?></td>
                                            <td><?= $param->concentration1 ?></td>
                                            <td><?= $param->concentration2 ?></td>
                                            <td class="timestamp"><?= $param->xtimestamp ?></td>
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