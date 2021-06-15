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
                        <div class="d-flex justify-content-between align-items-center flex-column">
                            <canvas id="disGraph" class="mb-5" style="max-width:60vw"></canvas>
                            <!-- <canvas id="dasGraph" style="max-width:60vw"></canvas> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>