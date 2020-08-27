<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-2 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="counter-sample-on-delivery">0</h3>
                        <p><?= lang('sample-on-delivery'); ?></p>
                    </div>
                    <a href="#card-sample-on-delivery" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="counter-sample-on-process">0</h3>
                        <p><?= lang('sample-on-process'); ?></p>
                    </div>
                    <a href="#card-sample-on-process" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="counter-sample-on-shipment">0</h3>
                        <p><?= lang('sample-on-shipment'); ?></p>
                    </div>
                    <a href="#card-sample-on-shipment" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3 id="counter-sample-finish">0</h3>
                        <p><?= lang('sample-finish'); ?></p>
                    </div>
                    <a href="#card-sample-finish" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-6 connectedSortable">
                <div class="card bg-info" id="card-sample-on-delivery">
                    <div class="card-header border-transparent">
                        <h3 class="card-title"><?= lang('sample-on-delivery') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table m-0" id="tb-sample-on-delivery">
                                <thead>
                                    <tr>
                                        <th align="center"><?= lang('field_no'); ?></th>
                                        <th align="center"><?= lang('field_type'); ?> <br /> (<?= lang('field_jenis') ?>)</th>
                                        <th align="center"><?= lang('field_brand'); ?></th>
                                        <th align="center"><?= lang('field_kontrak'); ?></th>
                                        <th align="center"><?= lang('field_item'); ?></th>
                                        <th align="center"><?= lang('field_style'); ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card bg-warning" id="card-sample-on-shipment">
                    <div class="card-header border-transparent">
                        <h3 class="card-title"><?= lang('sample-on-shipment') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table m-0" id="tb-sample-on-shipment">
                                <thead>
                                    <tr>
                                        <th align="center"><?= lang('field_no'); ?></th>
                                        <th align="center"><?= lang('field_type'); ?> <br /> (<?= lang('field_jenis') ?>)</th>
                                        <th align="center"><?= lang('field_brand'); ?></th>
                                        <th align="center"><?= lang('field_kontrak'); ?></th>
                                        <th align="center"><?= lang('field_item'); ?></th>
                                        <th align="center"><?= lang('field_style'); ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable">
                <div class="card bg-success" id="card-sample-on-process">
                    <div class="card-header border-transparent">
                        <h3 class="card-title"><?= lang('sample-on-process') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table m-0" id="tb-sample-on-process">
                                <thead>
                                    <tr>
                                        <th align="center"><?= lang('field_no'); ?></th>
                                        <th align="center"><?= lang('field_type'); ?> <br /> (<?= lang('field_jenis') ?>)</th>
                                        <th align="center"><?= lang('field_brand'); ?></th>
                                        <th align="center"><?= lang('field_kontrak'); ?></th>
                                        <th align="center"><?= lang('field_item'); ?></th>
                                        <th align="center"><?= lang('field_style'); ?></th>
                                        <th align="center"><?= lang('field_status'); ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card bg-purple" id="card-sample-finish">
                    <div class="card-header border-transparent">
                        <h3 class="card-title"><?= lang('sample-finish') ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table m-0" id="tb-sample-finish">
                                <thead>
                                    <tr>
                                        <th align="center"><?= lang('field_no'); ?></th>
                                        <th align="center"><?= lang('field_type'); ?> <br /> (<?= lang('field_jenis') ?>)</th>
                                        <th align="center"><?= lang('field_brand'); ?></th>
                                        <th align="center"><?= lang('field_kontrak'); ?></th>
                                        <th align="center"><?= lang('field_item'); ?></th>
                                        <th align="center"><?= lang('field_style'); ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div>
    <!-- /.container-fluid -->
</section>