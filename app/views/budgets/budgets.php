 
	<?php if(empty($budgets)){ ?>
		<li class='no-data text-center'><span class='text-muted'>There is no budget!!</span></li>
	
	<?php } else{
			foreach($budgets as $budget){?>
				<li id="<?= "budget-" . Encryption::encryptId($budget["id"]);?>" class="left clearfix">
					<span class="chat-img pull-left">
						<img src="<?= PUBLIC_ROOT . "img/profile_pictures/" . $budget["profile_picture"]; ?>" alt="User Picture" class="img-circle profile-pic-sm">
					</span>
					<div class="chat-body clearfix">
						<div class="header">
							<strong class="primary-font"><?= $budget["user_name"]; ?></strong>
								<small class="text-muted"><i class="fa fa-clock-o fa-fw"></i> <?= $this->timestamp($budget["date"]);?> </small>
								<?php if(Session::getUserId() === (int) $budget["user_id"] || Session::getUserRole() === "admin"){?>
									<span class="pull-right btn-group btn-group-xs">
										<a class="btn btn-default edit"><i class="fas fa-pencil-alt"></i></a>
										<a class="btn btn-danger delete"><i class="fa fa-times"></i></a>
									</span>
								<?php }?>
						</div>
						<p> <?= $this->autoLinks($this->encodeHTMLWithBR($budget["description"])); ?></p>
					</div>
				</li>
	<?php   }
		}?>


		
 
