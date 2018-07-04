
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
							 <?php 
									$data = $this->controller->user->dashboard();
									$updates = $data["updates"];
									$stats   = $data["stats"];
							?>
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fas fa-gavel fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $stats["budgets"]; ?></div>
                                    <div>Budget</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?= PUBLIC_ROOT . "Budget";?>">
                            <div class="panel-footer">
                                <span class="pull-left">See Open Budgets</span>
                                <span class="pull-right"><i class="fas fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fas fa-parachute-box fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $stats["suppliers"]; ?></div>
                                    <div>Suppliers</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?= PUBLIC_ROOT . "Suppliers/newSupplier";?>">
                            <div class="panel-footer">
                                <span class="pull-left">New Supplier</span>
                                <span class="pull-right"><i class="fas fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fas fa-cloud-upload-alt fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $stats["files"]; ?></div>
                                    <div>Files</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?= PUBLIC_ROOT . "Files";?>">
                            <div class="panel-footer">
                                <span class="pull-left">Upload File</span>
                                <span class="pull-right"><i class="fas fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fas fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $stats["users"]; ?></div>
                                    <div>Users</div>
                                </div>
                            </div>
                        </div>
						<?php if(Session::getUserRole() === "admin"){?>
							<a href="<?= PUBLIC_ROOT . "Admin/Users";?>">
						<?php } else {?>
							<a href="#">
						<?php } ?>
                            <div class="panel-footer">
                                <span class="pull-left"><?php if(Session::getUserRole() === "admin"){ echo "View All"; }?></span>
                                <span class="pull-right"><i class="fas fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            
			<hr>
			
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							<div class="pull-right">
								<a href="javascript:void(0)" class="label label-danger">Live</a>
							</div>
                            <i class="fas fa-stopwatch"></i> Latest Updates
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="latest-updates" class="list-group">
                               <?= $this->render(Config::get('VIEWS_PATH') . "dashboard/updates.php", array("updates" => $updates));?>
                            </div>
                            <!-- /.list-group -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

