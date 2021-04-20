<!-- Main content -->
<meta http-equiv="refresh" content="300">
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">

                <div class="card rounded-0">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <?php foreach ($instruments as $instrument) : ?>
                                <li class="nav-item"><a class="nav-link <?= $instrument->id == 1 ? 'active' : '' ?>" href="#instrument-<?= $instrument->id ?>" data-toggle="tab"><?= $instrument->name; ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <?php foreach ($instruments as $instrument) : ?>
                                <div class="tab-pane <?= $instrument->id == 1 ? 'active' : '' ?>" id="instrument-<?= $instrument->id ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?php foreach ($parameters[$instrument->id] as $parameter) : ?>
                                                <ul class="list-group list-group-unbordered">
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="h3"><?= $parameter->caption ?></p>
                                                            <span>
                                                                <p class="h1 d-inline" id="parameter_value_<?= $parameter->id; ?>"></p>
                                                                <p class="small d-inline"><?= $parameter->unit->name ?></p>
                                                            </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <?php endforeach ?>
                                        </div>
                                        <div class="col-md-8 border-left">
                                            <div id="graph" style="min-width: 764px; min-height: 380px;background-color:white;"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>