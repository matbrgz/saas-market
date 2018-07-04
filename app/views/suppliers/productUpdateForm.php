	
	
	<span class="chat-img pull-left">
		<img src="<?= PUBLIC_ROOT . "img/profile_pictures/" . $product["profile_picture"]; ?>" alt="Product Picture" class="img-circle profile-pic-sm">
	</span>
	
	<div class="chat-body clearfix">
		<div class="header">
			<strong class="primary-font"><?= $product["user_name"]; ?></strong>
			<small class="text-muted"><i class="fas fa-clock"></i><?= $this->timestamp($product["date"]) ?></small>
		</div>
		<form action="#" id="<?= "form-update-product-" . Encryption::encryptId($product["id"]); ?>" method="post">
            <div class="form-group">
                <label>Title:
                    <input type="text" maxlength="64" name="title" class="form-control" required value="<?= $product["title"]; ?>" />
                </label>
                <p class="help-block"><em>The maximum number of characters allowed is <strong>64</strong></em></p>
            </div>
            <div class="form-group">
				<textarea dir="auto" rows="3" maxlength="300" name="description" class="form-control" required
						placeholder="Write your Product Description"> <?= $this->encodeHTML($product["description"]); ?></textarea>
				<p class="help-block"><em>The maximum number of characters allowed is <strong>300</strong></em></p>
			</div>
            <div class="form-group">
                <label>Price:
                    <input maxlength="11" name="price_range" class="form-control" required value="<?= $product["price_range"]; ?>" />
                </label>
                <p class="help-block"><em>The maximum number of characters allowed is <strong>11</strong></em></p>
            </div>
            <div class="form-group">
                <label>Delivery Days:
                    <input maxlength="11" name="delivery_days" class="form-control" required value="<?= $product["delivery_days"]; ?>" />
                </label>
                <p class="help-block"><em>The maximum number of characters allowed is <strong>11</strong></em></p>
            </div>
			<div class="form-group form-actions text-right">
				<button type='button' name='cancel' value='cancel' class="btn btn-sm btn-default"><i class="fas fa-times"></i> Cancel</button>
				<button type='submit' name='edit' value='edit' class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
			</div>
		</form>
	</div>

				 
