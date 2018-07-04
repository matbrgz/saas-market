
	<?php if(empty($orders)){ ?>
		<li class='no-data text-center'><span class='text-muted'>There is no order!!</span></li>

	<?php } else{
			foreach($orders as $order){?>
				<li id="<?= "order-" . Encryption::encryptId($order["id"]);?>" class="left clearfix">
					<span class="chat-img pull-left">
						<img src="<?= PUBLIC_ROOT . "img/profile_pictures/" . $order["profile_picture"]; ?>" alt="User Picture" class="img-circle profile-pic-sm">
					</span>
					<div class="chat-body clearfix">
						<div class="header">
							<strong class="primary-font"><?= $order["user_name"]; ?></strong>
								<small class="text-muted"><i class="fa fa-clock-o fa-fw"></i> <?= $this->timestamp($order["date"]);?> </small>
								<?php if(Session::getUserId() === (int) $order["user_id"] || Session::getUserRole() === "admin"){?>
									<span class="pull-right btn-group btn-group-xs">
										<a class="btn btn-default edit"><i class="fas fa-pencil-alt"></i></a>
										<a class="btn btn-danger delete"><i class="fa fa-times"></i></a>
									</span>
								<?php }?>
						</div>
						<p> <?= $this->autoLinks($this->encodeHTMLWithBR($order["content"])); ?></p>
					</div>
				</li>
	<?php   }
		}?>
