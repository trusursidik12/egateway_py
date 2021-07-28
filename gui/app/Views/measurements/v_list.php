<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="row m-2">
                        <div class="col-sm">
                            <label>Instrument</label>
                            <select id="instrument_id" class="form-control">
                                <option value="">-- Select Instrument --</option>
                                <?php foreach ($instruments as $instrument) : ?>
                                    <option value="<?= $instrument->id ?>"><?= $instrument->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label>Sent To Trusur</label>
                            <select id="is_sent_cloud" class="form-control">
                                <option value="">-- Select Status --</option>
                                <option value="1">SENT</option>
                                <option value="0">NOT YET</option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label>Sent To SISPEK</label>
                            <select id="is_sent_klhk" class="form-control">
                                <option value="">-- Select Status --</option>
                                <option value="1">SENT</option>
                                <option value="0">NOT YET</option>
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
                            <button type="button" onclick="dataTable.draw()" class="btn btn-primary"><i class="fas fa-search mr-2"></i>Cari</button>
                            <button type="reset" onclick="location.reload()" class="btn btn-secondary"><i class="fas fa-sync mr-2"></i>Reset</button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="measurementList" class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Instrument</th>
                                    <!-- <th>Instrument Status</th> -->
                                    <!-- <th>Data Status</th> -->
                                    <th>Date</th>
                                    <th>Raw Data</th>
                                    <th>Correction</th>
                                    <th>Parameter</th>
                                    <th>Unit</th>
                                    <!-- <th>Validation</th> -->
                                    <!-- <th>Condition</th> -->
                                    <th>SENT&nbsp;TO&nbsp;TRUSUR</th>
                                    <!-- <th>SENT&nbsp;TO&nbsp;SISPEK</th> -->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>