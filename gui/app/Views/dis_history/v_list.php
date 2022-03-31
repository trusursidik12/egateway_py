<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="row m-2">
                        <div class="col-sm">
                            <label>Parameter</label>
                            <select id="parameter_id" class="form-control">
                                <option value="">-- Select Parameter --</option>
                                <?php foreach ($parameters as $parameter) : ?>
                                    <option value="<?= $parameter->id ?>"><?= $parameter->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label>Date Start</label>
                            <input type="date" id="date_start" class="form-control">
                        </div>
                        <div class="col-sm">
                            <label>Date End</label>
                            <input type="date" id="date_end" class="form-control">
                        </div>
                        <div class="col-sm">
                            <label>Action Filter</label><br>
                            <button type="button" class="btn btn-primary" id="btn-filter"><i class="fas fa-search mr-2"></i>Cari</button>
                            <button type="reset" onclick="location.reload()" class="btn btn-secondary"><i class="fas fa-sync mr-2"></i>Reset</button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="dis-history-table" class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th>Timestamp</th>
                                    <th>Parameter</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>