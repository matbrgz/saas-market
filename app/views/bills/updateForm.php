 
 
		<span class="chat-img pull-left">
			<img src="<?= PUBLIC_ROOT . "img/profile_pictures/" . $bills["profile_picture"]; ?>" alt="User Picture" class="img-circle profile-pic-sm">
		</span>
		<div class="chat-body clearfix">
			<div class="header">
				<strong class="primary-font"><?= $bills["user_name"]; ?></strong>
				<small class="text-muted"><i class="fa fa-clock-o fa-fw"></i> <?= $this->timestamp($bills["date"]);?> </small>
			</div>
			<form action="#" id="<?= "form-update-bill-" . Encryption::encryptId($bills["id"]);?>" method="post" >
				<div class="form-group">
					<label>Content <span class="text-danger">*</span></label>
					<textarea dir="auto" rows="3" maxlength="300" name="content" class="form-control" required 
						placeholder="What are you thinking?"> <?= $this->encodeHTML($bills["content"]); ?></textarea>
					<p class="help-block"><em>The maximum number of characters allowed is <strong>300</strong></em></p>
				</div>
				<div class="form-group form-actions text-right">
					<button type='button' name='cancel' value='cancel' class="btn btn-sm btn-default"><i class="fa fa-times"></i> Cancel</button>
					<button type='submit' name='edit' value='edit' class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
				</div>
			</form>
		</div>
	
				



		
 
