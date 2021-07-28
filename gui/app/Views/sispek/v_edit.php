<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <div class="card-title"><?= $__modulename ?></div>
                            <a href="<?= base_url("sispeks") ?>" class="btn btn-link">
                                <i class="fas fa-xs fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <form action="<?= base_url("sispek/update/" . @$sispek->id) ?>" method="post" id="form-edit">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Server</label>
                                        <input type="text" name="server" value="<?= old('server', @$sispek->server) ?>" class="form-control" placeholder="Server">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">APP ID</label>
                                        <input type="text" name="app_id" value="<?= old('app_id', @$sispek->app_id) ?>" class="form-control" placeholder="APP ID">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">APP Secret</label>
                                        <input type="text" name="app_secret" value="<?= old('app_secret', @$sispek->app_secret) ?>" class="form-control" placeholder="APP Secret">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">API Get Token</label>
                                        <input type="text" name="api_get_token" value="<?= old('api_get_token', @$sispek->api_get_token) ?>" class="form-control" placeholder="API Get Token">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">API Get Kode Cerobong</label>
                                        <input type="text" name="api_get_kode_cerobong" value="<?= old('api_get_kode_cerobong', @$sispek->api_get_kode_cerobong) ?>" class="form-control" placeholder="API Get Kode Cerobong">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">API Get Parameter</label>
                                        <input type="text" name="api_get_parameter" value="<?= old('api_get_parameter', @$sispek->api_get_parameter) ?>" class="form-control" placeholder="API Get Parameter">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">API Post Data</label>
                                        <input type="text" name="api_post_data" value="<?= old('api_post_data', @$sispek->api_post_data) ?>" class="form-control" placeholder="API Post Data">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">API Response Kode Cerobong</label>
                                        <input type="text" name="api_response_kode_cerobong" value="<?= old('api_response_kode_cerobong', @$sispek->api_response_kode_cerobong) ?>" class="form-control" placeholder="API Response Kode Cerobong">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">API Response Parameter</label>
                                        <input type="text" name="api_response_parameter" class="form-control" value="<?= old('api_response_parameter', @$sispek->api_response_parameter) ?>" placeholder="API Response Parameter">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Token</label>
                                        <input type="text" name="token" value="<?= old('token', @$sispek->token) ?>" class=" form-control" placeholder="Token">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Token Expired</label>
                                        <input type="datetime-local" name="token_expired" value="<?= old('token_expired', date('Y-m-d\TH:i:s', strtotime(@$sispek->token_expired))) ?>" class="form-control" placeholder="Token Expired">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex justify-content-end align-items-end">
                                    <button name="Save" type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>