
		<div dir='auto' class="panel-heading">
			<h5><?= $supplier["title"]; ?></h5>
		</div>
		
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<table class="table table-borderless table-vcenter remove-margin-bottom">
						<tbody>
							<tr>
								<td class="text-center" style="width: 80px;">
									<img src="<?= PUBLIC_ROOT . "img/profile_pictures/" . $supplier["profile_picture"]; ?>" alt="User Picture" class="img-circle profile-pic-sm">
								</td>
								<td>
									By <strong class="text-primary"><?= $supplier["user_name"]; ?></strong><br>
									<strong><?= $this->timestamp($supplier["date"]);?></strong>
								</td>
							</tr>
						</tbody>
					</table>
					<hr>
					<form action="<?php echo PUBLIC_ROOT; ?>Suppliers/update" id='form-update-supplier' method="post">
						<div class="form-group">
							<label>Title</label>
							<input dir="auto" type="text" name="title" value = "<?= $this->encodeHTML($supplier["title"]); ?>" class="form-control" required maxlength="80" placeholder="Title">
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea dir="auto" rows="20" maxlength="1800" name="description" class="form-control" required > <?= $this->encodeHTML($supplier["description"]); ?></textarea>
							<p class="help-block"><em>The maximum number of characters allowed is <strong>1800</strong></em></p>
						</div>
                        <div class="form-group">
                            <label>Email <span class='text-danger'>*</span></label>
                            <input dir="auto" type="text" name="email" class="form-control" required maxlength="64" value="<?= $supplier["email"]; ?>">
                        </div>
                        <div class="form-group">
                            <label>Website <span class='text-danger'>*</span></label>
                            <input dir="auto" type="text" name="website" class="form-control" required maxlength="48" value="<?= $supplier["website"]; ?>">
                        </div>
						<div class="form-group">
                            <input type="hidden" name="supplier_id" value="<?= $this->encodeHTML(Encryption::encryptId($supplier["id"])); ?>" />
                        </div>
						<div class="form-group">
                            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken(); ?>" />
                        </div>
						<div class="form-group form-actions text-right">
							<a href="<?= PUBLIC_ROOT . "Suppliers/View/" . urlencode(Encryption::encryptId($supplier["id"])); ?>">
								<button type='button' name='cancel' value='cancel' class="btn btn-md btn-default"><i class="fas fa-times"></i> Cancel</button>
							</a>
							<button type='submit' name='submit' value='edit' class="btn btn-md btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
						</div>
					</form>
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

			
