
	<?php if(empty($jobs)){ ?>
		<li class='no-data text-center'><span class='text-muted'>There is no job!!</span></li>

	<?php } else{
			foreach($jobs as $job){?>
				<li id="<?= "job-" . Encryption::encryptId($job["id"]);?>" class="left clearfix">
					<span class="chat-img pull-left">
						<img src="<?= PUBLIC_ROOT . "img/profile_pictures/" . $job["profile_picture"]; ?>" alt="User Picture" class="img-circle profile-pic-sm">
					</span>
					<div class="chat-body clearfix">
						<div class="header">
							<strong class="primary-font"><?= $job["user_name"]; ?></strong>
								<small class="text-muted"><i class="fa fa-clock-o fa-fw"></i> <?= $this->timestamp($job["date"]);?> </small>
								<?php if(Session::getUserId() === (int) $job["user_id"] || Session::getUserRole() === "admin"){?>
									<span class="pull-right btn-group btn-group-xs">
										<a class="btn btn-default edit"><i class="fas fa-pencil-alt"></i></a>
										<a class="btn btn-danger delete"><i class="fa fa-times"></i></a>
									</span>
								<?php }?>
						</div>
						<p> <?= $this->autoLinks($this->encodeHTMLWithBR($job["content"])); ?></p>
					</div>
				</li>
	<?php   }
		}?>
