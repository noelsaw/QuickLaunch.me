
<!-- Admin Palette -->
<section id="admin" title="Palette">
	
	<form action="" method="post" id="personalization-form">
	
		<ul id="admin-personalization">
			<li id="change-bg-color">
				<a href="#">Specify Background Color</a>
				<input type="text" name="bgcolor" id="bgcolor" value="<?php echo get_option('ql-bg-color') ?>">
			</li>
			<li id="change-text-color" class="color-bucket">
				<a href="#">Specify Body Text Color</a>
				<input type="hidden" name="text_color" id="text-color" value="<?php echo get_option('ql-text-color', '#000'); ?>">
			</li>
			<li id="change-heading-color" class="color-bucket">
				<a href="#">Specify Heading Text Color</a>
				<input type="hidden" name="heading_color" id="heading-color" value="<?php echo get_option('ql-heading-color', '#000'); ?>">
			</li>
			<li id="upload-logo">
				<a href="#" id="upload-logo-link">Upload new Logo</a>
				<input type="text" name="logoimage" id="logoimage" value="<?php echo get_option('ql-logo-image') ?>" class="hidden">
			</li>
			<li id="upload-bg">
				<a href="#" id="upload-bg-link">Upload new Background</a>
				<input type="text" name="bgimage" id="bgimage" value="<?php echo get_option('ql-bg-image') ?>" class="hidden">
			</li>
			<li id="upload-center-img">
				<a href="#" id="upload-centerimg-link">Upload Center Image</a>
				<input type="text" name="centerimage" id="centerimage" value="<?php echo get_option('ql-center-image') ?>" class="hidden">
			</li>
			<li>
				<a>Center youtube video URL</a>
				<input type="text" name="centervideo" id="center-video" value="<?php echo get_option('ql-video'); ?>" />
					
			</li>
		</ul>
		
		<div id="ql-box-opacity">	
			<p>Rounded box opacity:</p>
			<input type="hidden" name="box_opacity" id="box-opacity" value="<?php echo get_option('ql-box-opacity', 1) ?>">
			<div id="box-opacity-slider" class="nouislider"></div>
		</div>
		
		<ul id="admin-social-networks">
			<li id="admin-twitter-url"><input type="text" name="twitter" value="<?php echo get_option('ql-twitter-url') ?>" size="21"></li>
			<li id="admin-facebook-url"><input type="text" name="facebook" value="<?php echo get_option('ql-facebook-url') ?>" size="21"></li>
			<li id="admin-linkedin-url"><input type="text" name="linkedin" value="<?php echo get_option('ql-linkedin-url') ?>" size="21"></li>
			<li id="admin-googleplus-url"><input type="text" name="googleplus" value="<?php echo get_option('ql-googleplus-url') ?>" size="21"></li>
			<li id="admin-youtube-url"><input type="text" name="youtube" value="<?php echo get_option('ql-youtube-url') ?>" size="21"></li>
		</ul>
		
		<div id="admin-email">
			<label><input type="checkbox" name="show_email" <?php checked(get_option('ql-show-email')); ?> value="1" /> Show email</label>
			
			<p>Submit Button Color:
			<select id="btn-color" name="btn_color">
				<option value="blue"<?php selected(get_option('ql-btn-color'), 'blue') ?>>Blue</option>
				<option value="gray"<?php selected(get_option('ql-btn-color'), 'gray') ?>>Gray</option>
				<option value="green"<?php selected(get_option('ql-btn-color'), 'green') ?>>Green</option>
				<option value="red"<?php selected(get_option('ql-btn-color'), 'red') ?>>Red</option>
			</select></p>
		</div>
			
		<div id="admin-position">
			<p>Position: </p>
			<label><input type="radio" name="content_position" value="left" <?php checked(get_option('ql-content-position'), 'left')?> />Left</label>
			<label><input type="radio" name="content_position" value="center" <?php checked(get_option('ql-content-position'), 'center')?> />Center</label>
			<label><input type="radio" name="content_position" value="right" <?php checked(get_option('ql-content-position'), 'right')?> />Right</label>
		</div>
		
		<div id="content-padding-container">	
			<p>Content Padding:</p>
			<input type="hidden" name="content_padding" id="content-padding" value="<?php echo get_option('ql-content-padding') ?>">
			<div id="content-padding-slider" class="nouislider"></div>
		</div>
		
		<div>
				<label><input id="rounded-box-background" type="checkbox" name="rounded_box_background" <?php checked(get_option('ql-rounded-box-background')); ?> value="1" /> Rounded box background</label>
				<br/>
				<label><input id="square-box-background" type="checkbox" name="square_box_background" <?php checked(get_option('ql-square-box-background')); ?> value="1" /> Square box background</label>
				
		</div>
		<br />
		<div>
				<label>Select Google Web font for heading:</label>
				<select name="google_font" id="google-font">
						<option value="" <?php selected(get_option('ql-google-font'), '') ?> > -Don't use google web fonts- </option>
						<option value="Abril Fatface" <?php selected(get_option('ql-google-font'), 'Abril Fatface') ?>>Abril Fatface</option>
						<option value="Droid Sans" <?php selected(get_option('ql-google-font'), 'Droid Sans') ?>>Droid Sans</option>
						<option value="Droid Serif" <?php selected(get_option('ql-google-font'), 'Droid Serif') ?>>Droid Serif</option>
						<option value="Droid Sans Mono" <?php selected(get_option('ql-google-font'), 'Droid Sans Mono') ?>>Droid Sans Mono</option>
						<option value="Hammersmith One" <?php selected(get_option('ql-google-font'), 'Hammersmith One') ?>>Hammersmith One</option>
						<option value="Lato" <?php selected(get_option('ql-google-font'), 'Lato') ?>>Lato</option>
						<option value="Playfair Display" <?php selected(get_option('ql-google-font'), 'Playfair Display') ?>>Playfair Display</option>
						<option value="Ubuntu" <?php selected(get_option('ql-google-font'), 'Ubuntu') ?>>Ubuntu</option>
						<option value="UnifrakturMaguntia" <?php selected(get_option('ql-google-font'), 'UnifrakturMaguntia') ?>>UnifrakturMaguntia</option>
						<option value="Vollkorn" <?php selected(get_option('ql-google-font'), 'Vollkorn') ?>>Vollkorn</option>
				</select>
		</div>
		
		<div>
				<label><input type="checkbox" name="widgets_active" value="1" <?php checked(get_option('ql-widgets-active')); ?> /> Widgets</label>
		</div>
	
	</form>
	
	<p id="admin-submit">
		<small class="gray indicator hidden" id="loading-indicator">Uploading File</small>
		<a href="#" id="admin-save-changes">See site without palette</a>
	</p>
	
</section>
<!-- End Admin Palette -->
