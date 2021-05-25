<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">

                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">Stacks List</div>
                            <div>
                                <a href="/stack/add" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus fa-xs"></i> Add Stack
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
                                        <th>Code</th>
                                        <th>Parameter</th>
                                        <th>Height</th>
                                        <th>Diameter</th>
                                        <th>Flow</th>
                                        <th>Longitude</th>
                                        <th>Latitue</th>
                                        <th>Oxygen Reference (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stacks as $stack) : ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url("stack/edit/{$stack->id}") ?>" class="btn btn-sm btn-primary" title='Edit'>
                                                    <i class="fa fa-xs fa-pen"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger btn-delete" data-id='<?= @$stack->id ?>' title='Delete'>
                                                    <i class="fa fa-xs fa-trash"></i>
                                                </button>
                                            </td>
                                            <td class="stack_id"><?= @$stack->id ?></td>
                                            <td><?= @$stack->code ?></td>
                                            <td><?= @$parameters[$stack->id] ?></td>
                                            <td><?= @$stack->height ?></td>
                                            <td><?= @$stack->diameter ?></td>
                                            <td><?= @$stack->flow ?></td>
                                            <td><?= @$stack->lon ?></td>
                                            <td><?= @$stack->lat ?></td>
                                            <td><?= @$stack->oxygen_reference ?></td>
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