
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Suppliers</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
			   <div class="col-sm-2 col-lg-2"></div>
               <div class="col-sm-8 col-lg-8">
					<!-- Budget Block -->
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fas fa-parachute-box"></i> Suppliers List
							<div class="pull-right">
								<button 
									class="btn btn-success btn-xs" onclick="window.location='<?= PUBLIC_ROOT . "Suppliers/newSupplier";?>';">
									<i class="fas fa-plus"></i> New Supplier
								</button>
							</div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="list-suppliers" class="table table-hover">
                                    <thead>
                                        <tr>
											<th>Author</th>
											<th>Supplier</th>
											<th class="text-center"><i class="fas fa-box-open"></i></th>
										</tr>
                                    </thead>
                                    <tbody>
                                       <?php 
											$suppliersData = $this->controller->supplier->getAll(empty($pageNum)? 1: $pageNum);
											echo $this->render(Config::get('VIEWS_PATH') . "suppliers/suppliers.php", array("suppliers" => $suppliersData["suppliers"]));
										?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
							<hr>
							<div class="text-right">
								<ul class="pagination">
									<?php 
										echo $this->render(Config::get('VIEWS_PATH') . "pagination/default.php", 
                                            ["pagination" => $suppliersData["pagination"], "link"=> "Suppliers"]);
									?>
								</ul>
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
				</div>
			<!-- END Budget Block -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

