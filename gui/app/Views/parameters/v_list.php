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
                                        <th>Stack</th>
                                        <th>Name</th>
                                        <th>Caption</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Unit</th>
                                        <th>Molecular Mass</th>
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
                                            <td style="min-width: 60px;" nowrap>
                                                <a href="<?= base_url("parameter/edit/{$param->id}") ?>" class="btn btn-sm btn-primary" title='Edit'>
                                                    <i class="fa fa-xs fa-pen"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger btn-delete" data-id='<?= @$param->id ?>' title='Delete'>
                                                    <i class="fa fa-xs fa-trash"></i>
                                                </button>
                                            </td>
                                            <td><?= $param->id ?></td>
                                            <td><?= $param->stack_code ?></td>
                                            <td><?= $param->name ?></td>
                                            <td><?= $param->caption ?></td>
                                            <td><?= $param->p_type ?></td>
                                            <td class="text-center"><span class="badge <?= $param->status_id == 1 ? 'badge-success' : ($param->status_id == 2 ? 'badge-warning' : ($param->status_id == 3 ? 'badge-primary' : ($param->status_id == 4 ? 'badge-danger' : ''))) ?>"><?= $param->status_id == 0 ? 'undefined' : $param->status ?></span></td>
                                            <td><?= $param->unit ?></td>
                                            <td><?= $param->molecular_mass ?></td>
                                            <td class="text-center"><?=
                                                                    $param->is_view == 1 ? '<span class="badge badge-success">
                                                                        Showed
                                                                        </span>' : '<span class="badge badge-danger">
                                                                            Hidden
                                                                        </span>'; ?>
                                            </td>
                                            <td class="text-center"><?=
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
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td colspan="13"><b>Formula : </b><?= $param->formula ?></td>
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