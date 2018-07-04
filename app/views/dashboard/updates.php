
	<?php if(empty($updates)){ ?>
		<div class='list-group-item text-center no-data'><span class="text-muted">There is no updates yet!</span></div>
	<?php } else{ ?>
	
	<?php foreach($updates as $update){ ?>
	
			<div class="list-group-item">
				<?php 
					$logo = "";
					switch($update["target"]){
                        case "orders":
                            $logo = "<i class='fas fa-shopping-basket'></i>";
                            break;
					    case "budgets":
							$logo = "<i class='fa fa-gavel'></i>";
							break;
						case "suppliers":
							$logo = "<i class='fa fa-parachute-box'></i>";
							break;
						case "files":
							$logo = "<i class='fa fa-cloud-upload'></i>";
							break;
					}		
				?>
				
				<?= $logo; ?>
				
				<?= $this->truncate($this->encodeHTML($update["title"]),75); ?><br>&nbsp;&nbsp;
				<strong class="text-primary small">By <?= $update["name"];?></strong>
				<span class="pull-right text-muted small"><em><?= $this->timestamp($update["date"]);?></em></span>
			</div>
  <?php }
	
	}?>