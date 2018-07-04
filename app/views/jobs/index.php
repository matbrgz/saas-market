
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Jobs</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
			   <div class="col-sm-2 col-lg-2"></div>
               <div class="col-sm-8 col-lg-8">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fas fa-shopping-basket"></i> New job
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="<?php echo PUBLIC_ROOT; ?>Jobs/create" id="form-create-jobs" method="post">
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
													<i class="fa fa-check"></i> Place job
											</button>
										</div>
                                    </form>
                                    <?php
                                        if(!empty(Session::get('jobs-errors'))){
                                            echo $this->renderErrors(Session::getAndDestroy('jobs-errors'));
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
					<!-- Jobs Block -->
					<div class="panel panel-default">
						<!-- Jobs Title -->
						<div class="panel-heading">
							<i class="fa fa-rss"></i> Jobs
						</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul id="list-jobs" class="chat">
                                <?php
									$jobsData = $this->controller->jobs->getAll(empty($pageNum)? 1: $pageNum);
									echo $this->render(Config::get('VIEWS_PATH') . "jobs/jobs.php", array("jobs" => $jobsData["jobs"]));
								?>
                            </ul>

							<hr>
							<div class="text-right">
								<ul class="pagination">
									<?php
										echo $this->render(Config::get('VIEWS_PATH') . "pagination/default.php",
                                            ["pagination" => $jobsData["pagination"], "link" => "Jobs"]);
									?>
								</ul>
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
					<!-- /.panel -->
				</div>
				<!-- END Jobs Block -->
			</div>
			<!-- /.row -->
		</div>
