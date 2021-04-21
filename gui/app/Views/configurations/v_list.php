<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">

                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">Configuration Lists</div>
                            <div>
                                <a href="/configuration/add" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus fa-xs"></i> Add Configuration
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
                                        <th>eGateway Code</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Province</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Interval Request</th>
                                        <th>Interval Sending</th>
                                        <th>Interval Retry</th>
                                        <th>Interval Average</th>
                                        <th>Delay Sending</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($configurations as $config) : ?>
                                        <tr>
                                            <td style="min-width: 60px;">
                                                <a href="<?= base_url("configuration/edit/{$config->id}") ?>" class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fas fa-xs fa-pen"></i>
                                                </a>
                                                <button data-id="<?= $config->id ?>" type="button" class="btn btn-sm btn-danger btn-delete" title="Delete">
                                                    <i class="fas fa-xs fa-trash"></i>
                                                </button>
                                            </td>
                                            <td><?= @$config->id ?></td>
                                            <td><?= @$config->egateway_code ?></td>
                                            <td><?= @$config->customer_name ?></td>
                                            <td><?= @$config->address ?></td>
                                            <td><?= @$config->city ?></td>
                                            <td><?= @$config->province ?></td>
                                            <td><?= @$config->latitude ?></td>
                                            <td><?= @$config->longitude ?></td>
                                            <td><?= @$config->interval_request ?></td>
                                            <td><?= @$config->interval_sending ?></td>
                                            <td><?= @$config->interval_retry ?></td>
                                            <td><?= @$config->interval_average ?></td>
                                            <td><?= @$config->delay_sending ?></td>
                                            <td><?= @$config->created_by ?></td>
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