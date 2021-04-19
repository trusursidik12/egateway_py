<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">

                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <li class="nav-item"><a class="nav-link <?= $i == 1 ? 'active' : '' ?>" href="#cems-<?= $i ?>" data-toggle="tab">CEMS-<?= $i ?></a></li>
                            <?php endfor; ?>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <?php for ($j = 1; $j <= 3; $j++) : ?>
                                <div class="tab-pane <?= $j == 1 ? 'active' : '' ?>" id="cems-<?= $i ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?php for ($i = 0; $i <= 5; $i++) : ?>
                                                <ul class="list-group list-group-unbordered">
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="h3">SO <?= $j ?></p>
                                                            <span>
                                                                <p class="h1 d-inline"><?= rand(0, 99) ?></p>
                                                                <p class="small d-inline">mg/m3</p>
                                                            </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="col-md-8 border-left">
                                            <div class="position-relative mb-4">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>
                                                <canvas id="visitors-chart" width="764" class="chartjs-render-monitor" style="display: block; width: 764px; min-height: 380px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>