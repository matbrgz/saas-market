		
			<div dir='auto' class="panel-heading">
				<?php if(Session::getUserId() === (int) $supplier["user_id"] || Session::getUserRole() === "admin"){?>
					<div class="pull-right">
						<a href="<?= PUBLIC_ROOT . "Suppliers/View/" . urlencode(Encryption::encryptId($supplier["id"])) . "?action=update"; ?>">
							<button type="button" class="btn btn-default btn-circle edit"><i class="fas fa-pencil-alt"></i></button>
						</a>
						<a href="<?= PUBLIC_ROOT . "Suppliers/delete/" . urlencode(Encryption::encryptId($supplier["id"])) . "?csrf_token=" . urlencode(Session::generateCsrfToken()); ?>">
							<button type="button" class="btn btn-danger btn-circle delete"><i class="fas fa-times"></i></button>
						</a>
					</div>
				<?php }?>
                <h5>Supplier: <?= $supplier["title"]; ?></h5>
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
                                    <a href="mailto:<?= $supplier["email"]; ?>"><?= $supplier["email"]; ?></a><br/>
                                    <a href="http://<?= $supplier["website"]; ?>/">Website</a><br/>
                                    <small class="text-primary">Created by <?= $supplier["user_name"]; ?></small><br/>
                                    <small class="text-primary">On <?= $this->timestamp($supplier["date"]);?></small>
								</td>
							</tr>
						</tbody>
						</table>
						<hr>
						<p dir="auto"><?= $this->autoLinks($this->encodeHTMLWithBR($supplier["description"]));?></p>
					</div>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
