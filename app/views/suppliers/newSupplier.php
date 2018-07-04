
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
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fas fa-edit"></i> New Supplier
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">

                                    <?php if(empty(Session::get('suppliers-success'))){ ?>
                                    <form action="<?php echo PUBLIC_ROOT; ?>Suppliers/create" id="form-create-supplier" method="post">
                                        <div class="form-group">
                                            <label>Title <span class='text-danger'>*</span></label>
                                            <input dir="auto" type="text" name="title" class="form-control" required maxlength="60" placeholder="Title">
                                        </div>
										<div class="form-group">
                                            <label>Description <span class='text-danger'>*</span>
                                                <textarea dir="auto" class="form-control" name="description" required rows="20" maxlength="1800"></textarea>
                                            </label>
											<p class="help-block"><em>The maximum number of characters allowed is <strong>1800</strong></em></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Email <span class='text-danger'>*</span></label>
                                            <input dir="auto" type="text" name="email" class="form-control" required maxlength="64" placeholder="yourname@company.com">
                                        </div>
                                        <div class="form-group">
                                            <label>Website <span class='text-danger'>*</span></label>
                                            <input dir="auto" type="text" name="website" class="form-control" required maxlength="48" placeholder="www.yoursite.com">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken(); ?>" />
                                        </div>
										<div class="form-group form-actions text-right">
											 <button type="submit" name="submit" value="submit" class="btn btn-md btn-success">
												<i class="fas fa-check"></i> Post
											</button>
										</div>
                                    </form>
                                    <?php } else { echo $this->renderSuccess(Session::getAndDestroy('suppliers-success')); } ?>
                                    <?php 
                                        if(!empty(Session::get('suppliers-errors'))){
                                            echo $this->renderErrors(Session::getAndDestroy('suppliers-errors'));
                                        }
                                    ?>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
				</div>
			<!-- END Budget Block -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

