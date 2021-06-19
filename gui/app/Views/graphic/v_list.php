<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div id="parameter">
                                <?php foreach ($stacks as $stack) : ?>
                                    <a href="<?= base_url("graphic/index/{$stack->id}") ?>" class="btn btn-sm <?= $id == $stack->id ? "btn-primary" : "btn-link" ?> my-1">
                                        <?= $stack->code ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <a href="#" onclick="return window.history.go(-1);" class="btn btn-sm btn-link">
                                <i class="fas fa-xs fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="filter">
                            <div class="row">
                                <div class="col-2 col d-flex align-items-center"><label>Filter Data</label></div>
                                <div class="col"><label>Date Start</label><input type="date" required name="date_start" class="form-control form-control-sm"></div>
                                <div class="col"><label>Date End</label><input type="date" required name="date_end" class="form-control form-control-sm"></div>
                                <div class="col d-flex align-items-end"><button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-xs fa-search"></i></button></div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-10">
                                <div class="d-flex justify-content-between align-items-center flex-column">
                                    <canvas id="disGraph" class="mb-5" style="max-width:60vw"></canvas>
                                    <span id="datemaster"></span>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="d-flex justity-content-start align-items-start flex-column">
                                    <b>Parameter <?= $_stack->code; ?></b>
                                    <?php foreach ($parameters as $param) : ?>
                                        <a href="?parameter=<?= $param->id ?>" class="btn <?= $param->id == @$parameter->id ? "btn-primary" : "btn-outline-primary" ?> my-1"><?= $param->name ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>