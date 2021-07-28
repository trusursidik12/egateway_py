<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table-sispek">
                                <thead>
                                    <th style="width: 5vw;"></th>
                                    <th>Server</th>
                                    <th>APP ID</th>
                                    <th>APP Secret</th>
                                    <th>API Get Token</th>
                                    <th>API Get Kode Cerobong</th>
                                    <th>API Get Parameter</th>
                                    <th>API Post Data</th>
                                    <th>API Response Kode Cerobong</th>
                                    <th>API Response Parameter</th>
                                    <th>Token</th>
                                    <th>Token Expired</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($sispeks as $sispek) : ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url("sispek/edit/$sispek->id") ?>" class="btn btn-sm btn-info">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </td>
                                            <td><?= $sispek->server ?></td>
                                            <td><?= $sispek->app_id ?></td>
                                            <td><?= $sispek->app_secret ?></td>
                                            <td><?= $sispek->api_get_token ?></td>
                                            <td><?= $sispek->api_get_kode_cerobong ?></td>
                                            <td><?= $sispek->api_get_parameter ?></td>
                                            <td><?= $sispek->api_post_data ?></td>
                                            <td><?= $sispek->api_response_kode_cerobong ?></td>
                                            <td><?= $sispek->api_response_parameter ?></td>
                                            <td><?= $sispek->token ?></td>
                                            <td><?= $sispek->token_expired ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>