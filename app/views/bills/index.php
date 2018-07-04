
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Bills</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
			   <div class="col-sm-2 col-lg-2"></div>
               <div class="col-sm-8 col-lg-8">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fas fa-shopping-basket"></i> New bill
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="<?php echo PUBLIC_ROOT; ?>Bills/create" id="form-create-bills" method="post">
                                        <div class="form-group">
                                            <label>Content <span class="text-danger">*</span></label>
                                            <textarea dir="auto" rows="3" maxlength="300" name="content" class="form-control" required placeholder="Message"></textarea>
											<p class="help-block"><em>The maximum number of characters allowed is <strong>300</strong></em></p>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken(); ?>" />
                                        </div>
										<div class="form-group form-actions text-right">
											 <button type="submit" name="submit" value="submit" class="btn btn-md btn-success">
													<i class="fa fa-check"></i> Place bill
											</button>
										</div>
                                    </form>
                                    <?php
                                        if(!empty(Session::get('bills-errors'))){
                                            echo $this->renderErrors(Session::getAndDestroy('bills-errors'));
                                        }
                                    ?>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>

					<hr>
					<!-- Bills Block -->
					<div class="panel panel-default">
						<!-- Bills Title -->
						<div class="panel-heading">
							<i class="fa fa-rss"></i> Bills
						</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul id="list-bills" class="chat">
                                <?php
									$billsData = $this->controller->bills->getAll(empty($pageNum)? 1: $pageNum);
									echo $this->render(Config::get('VIEWS_PATH') . "bills/bills.php", array("bills" => $billsData["bills"]));
								?>
                            </ul>

							<hr>
							<div class="text-right">
								<ul class="pagination">
									<?php
										echo $this->render(Config::get('VIEWS_PATH') . "pagination/default.php",
                                            ["pagination" => $billsData["pagination"], "link" => "Bills"]);
									?>
								</ul>
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
					<!-- /.panel -->
				</div>
				<!-- END Bills Block -->
			</div>
			<!-- /.row -->
		</div>
