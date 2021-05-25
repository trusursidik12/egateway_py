<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">

                <div class="card rounded-0">
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
                                        <th>Interval DAS Logs</th>
                                        <th>Interval Average</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($configurations as $config) : ?>
                                        <tr>
                                            <td style="min-width: 60px;">
                                                <a href="<?= base_url("configuration/edit/{$config->id}") ?>" class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fas fa-xs fa-pen"></i>
                                                </a>
                                            </td>
                                            <td><?= @$config->id ?></td>
                                            <td><?= @$config->egateway_code ?></td>
                                            <td><?= @$config->customer_name ?></td>
                                            <td><?= @$config->address ?></td>
                                            <td><?= @$config->city ?></td>
                                            <td><?= @$config->province ?></td>
                                            <td><?= @$config->latitude ?></td>
                                            <td><?= @$config->longitude ?></td>
                                            <td><?= @$config->interval_das_logs * 1 ?> minute(s)</td>
                                            <td><?= @$config->interval_average * 1 ?> minute(s)</td>
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