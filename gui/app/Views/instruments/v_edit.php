<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mx-auto">

                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">Instrument Add</div>
                            <div>
                                <a href="#" onclick="return window.history.go(-1);" class="btn btn-sm btn-link">
                                    <i class="fa fa-arrow-left fa-xs"></i> Back
                                </a>
                            </div>
                        </div>

                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Instrument Name</label>
                                <input type="text" name="name" placeholder="Instrument Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Stack</label>
                                <select name="stack_id" class="form-control">
                                    <option value="">Select Stack</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Parameter</label>
                                <select name="parameter_id[]" class="form-control" multiple>
                                    <option value="" disabled>Select Parameter</option>
                                    <option value="1">SO2</option>
                                    <option value="2">NO</option>
                                    <option value="3">O2</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Type Instrument</label>
                                <select name="i_type" class="form-control">
                                    <option value="">Select Type Instrument</option>
                                    <option value="CEMS">CEMS</option>
                                    <option value="AQMS">AQMS</option>
                                    <option value="ISPUTEN">ISPUTEN</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status_id" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="1">Normal</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button name="Save" type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>