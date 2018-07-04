

	<?php if(empty($products)){ ?>
		<li class='no-data'><div class='text-center'><span class='text-muted'>There is no products!</span></div></li>
	
	<?php } else{
			foreach($products as $product){?>
			
				<li id="<?= "product-" . Encryption::encryptId($product["id"]); ?>" class="left clearfix">
					<span class="chat-img pull-left">
						<img src="<?= PUBLIC_ROOT . "img/profile_pictures/" . $product["profile_picture"]; ?>" alt="Product Picture" class="img-circle profile-pic-sm">
					</span>
					
					<div class="chat-body clearfix">
						<div class="header">
                            <strong class="primary-font"><?= $product["title"]; ?></strong><br/>
                            Price (not final price): $<?= $product["price_range"]; ?><br/>
                            Estimated delivery time: <?= $product["delivery_days"]; ?> days<br/>
                            <small class="text-muted">Created by <?= $product["user_name"]; ?></small><br/>
                            <small class="text-muted">On <i class="fas fa-clock"></i><?= $this->timestamp($product["date"]) ?></small>
                            <span class="pull-right btn-group btn-group-xs">
                                <a class="btn btn-default"><i class="far fa-money-bill-alt"></i> Order Now</a>
                                <a class="btn btn-default"><i class="fas fa-gavel"></i> Ask for a budget</a>
                            <?php if(Session::getUserId() === (int) $product["user_id"] || Session::getUserRole() === "admin"){ ?>
                                <a class="btn btn-default edit"><i class="fas fa-pencil-alt"></i></a>
                                <a class="btn btn-danger delete"><i class="fas fa-times"></i></a>
							<?php }?>
                            </span>
						</div>
						<p><?= $this->autoLinks($this->encodeHTMLWithBR($product["description"])); ?></p>
					</div>
				 </li>
	<?php   }
		}?>
