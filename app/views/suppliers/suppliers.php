 

	<?php if(empty($suppliers)){ ?>
		<tr class='no-data'><td colspan='3' class='text-muted text-center'>There is no suppliers!</td></tr>
	
	<?php }else{
			foreach($suppliers as $supplier){?>
				<tr>
					<td style="width: 20%;"><strong><?= $supplier["user_name"];?></strong><br><em><?= $this->timestamp($supplier["date"]); ?></em><br></td>
					<td>
						<a href="<?= PUBLIC_ROOT . "Suppliers/View/" . urlencode(Encryption::encryptId($supplier["id"])); ?>">
							<strong><?= $this->truncate($this->encodeHTML($supplier["title"]),25); ?></strong>
						</a><br>
						<span class="text-muted"><?= $this->truncate($this->encodeHTML($supplier["description"]),30); ?></span>
					</td>
					<td class="text-center"><h5><strong class="text-primary"><?= $supplier["products"]; ?></strong></h5></td>
				</tr>
	<?php   }
		}?>


		
