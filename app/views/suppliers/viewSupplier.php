
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Supplier</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
			   <div class="col-sm-2 col-lg-2"></div>
               <div class="col-sm-8 col-lg-8">
					<div id="view-supplier" class="panel panel-default">
                       <?php 
                            $supplier = $this->controller->supplier->getById($supplierId);

                       		if(empty($action)){
								echo $this->render(Config::get('VIEWS_PATH') . "suppliers/supplier.php", array("supplier" => $supplier));
                       		}else if($action === "update"){
                       			echo $this->render(Config::get('VIEWS_PATH') . 'suppliers/supplierUpdateForm.php', array("supplier" => $supplier));
                       		}
						?>
                    </div>
					
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fas fa-inbox"></i> Products
                        </div>
                        <div class="panel-body">
                            <ul id="list-products" class="chat">
                                <?php 
									$productsData = $this->controller->product->getAll($supplierId);
									echo $this->render(Config::get('VIEWS_PATH') . "suppliers/products.php", array("products" => $productsData["products"]));
								?>
                            </ul>
							
							<hr>
							<form action="#" id="form-create-product" method="post">
                                <div class="form-group">
                                    <label>Title:
                                        <input type="text" maxlength="64" name="title" class="form-control" required placeholder="Product Title" />
                                    </label>
                                    <p class="help-block"><em>The maximum number of characters allowed is <strong>64</strong></em></p>
                                </div>
								<div class="form-group">
									<textarea dir="auto" rows="3" maxlength="300" name="description" required class="form-control" placeholder="Write your Product Description"></textarea>
									<p class="help-block"><em>The maximum number of characters allowed is <strong>300</strong></em></p>
								</div>
                                <div class="form-group">
                                    <label>Price:
                                        <input maxlength="11" name="price_range" class="form-control" required placeholder="Value in Dollars" />
                                    </label>
                                    <p class="help-block"><em>The maximum number of characters allowed is <strong>11</strong></em></p>
                                </div>
                                <div class="form-group">
                                    <label>Delivery Days:
                                        <input maxlength="11" name="delivery_days" class="form-control" required placeholder="Estimated delivery time in days" />
                                    </label>
                                    <p class="help-block"><em>The maximum number of characters allowed is <strong>11</strong></em></p>
                                </div>
								<div class="form-group form-actions text-right">
									<button type="submit" name="submit" value="submit" class="btn btn-sm btn-success">
										<i class="fas fa-check"></i> Create New Product
									</button>
								</div>
                            </form>

							<!-- View More -->
								<div class="text-center">
									<ul class="pagination">
									<?php 
										echo $this->render(Config::get('VIEWS_PATH') . "pagination/products.php", array("pagination" => $productsData["pagination"]));
									?>
									</ul>
								</div>
							<!-- END View More -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
				</div>
			<!-- END Supplier Block -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

