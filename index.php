<?php get_header() ?>
<?php
$ql_widgets = get_option('ql_widgets');
$ql_footer = get_option('ql_footer');
$ql_layout = get_option('ql_layout');
$ql_social = get_option('ql_social');
$ql_content = get_option('ql_content');
$ql_title_tagline = get_option('ql_title_tagline');
?>
	
		<!-- Page Header -->
		<header>
			<div id="site-logo" class="<?php echo ($ql_title_tagline['logo']?'':'hidden') ?>">
				<img src="<?php echo $ql_title_tagline['logo']; ?>" style="max-width:100%;" />
			</div>
			<div id="site-title-and-desc" class="<?php echo ($ql_title_tagline['logo']?'hidden':'') ?>">
				<h1 id="site-title"><?php echo stripslashes(get_bloginfo('title')) ?></h1>
				<h2 id="site-desc"><?php echo stripslashes(get_bloginfo('description')) ?></h2>
			</div>
		</header>
		<!-- End Page Header -->
		<div id="widgets" class="<?php echo $ql_widgets['wordpress']?'':'hidden' ?>" >
			<?php get_sidebar('top'); ?>
		</div>
		
		<?php if ( $ql_widgets['image'] || ! is_admin()): ?>
		<!-- Center Image -->
		<section id="center-image" class="<?php echo $ql_widgets['image']?'':'hidden' ?>" >
			<img src="<?php echo $ql_widgets['image'] ?>" style="width:100%;" />
		</section>
		<!-- End Center Image -->
		<?php endif; ?>
		
		
		<!-- Image slider -->
		<section id="image-slider" class="<?php echo $ql_widgets['slider']?'':'hidden'; ?>">
			<div id="coin-slider">
				<?php if($ql_widgets['slider_image_1']): ?>
				<img id="slider-image-1" src="<?php echo $ql_widgets['slider_image_1'] ?>" style="width:100%;" />
				<?php endif; ?>
				<?php if($ql_widgets['slider_image_2']): ?>
				<img id="slider-image-2" src="<?php echo $ql_widgets['slider_image_2'] ?>" style="width:100%;" />
				<?php endif; ?>
				<?php if($ql_widgets['slider_image_3']): ?>
				<img id="slider-image-3" src="<?php echo $ql_widgets['slider_image_3'] ?>" style="width:100%;" />
				<?php endif; ?>
				<?php if($ql_widgets['slider_image_4']): ?>
				<img id="slider-image-4" src="<?php echo $ql_widgets['slider_image_4'] ?>" style="width:100%;" />
				<?php endif; ?>
			</div>
		</section>
		<!-- End Image slider -->
		
		<?php
		if($ql_widgets['video'] || !is_admin()): 
			$urlParams = parse_url($ql_widgets['video']);
			parse_str($urlParams['query'], $youtubeParams);
		?>
		<!-- Video -->
		<section id="video" class="<?php echo $ql_widgets['video']?'':'hidden' ?>" >
			<object width="<?php echo $width = 460; ?>" height="<?php echo $height = floor($width * (3/4)); ?>">
			  <param name="movie"
					 value="http://www.youtube.com/v/<?php echo $youtubeParams['v']; ?>&version=3&autohide=1&showinfo=0"></param>
			  <param name="allowScriptAccess" value="always"></param>
			  <embed src="http://www.youtube.com/v/<?php echo $youtubeParams['v']; ?>&version=3&autohide=1&showinfo=0"
					 type="application/x-shockwave-flash"
					 allowscriptaccess="always"
					 width="<?php echo $width; ?>" height="<?php echo $height; ?>"></embed>
			</object>
		</section>
		<!-- End Video -->
		<?php endif; ?>
		
		<!-- Main Content -->
		<section id="content">
		
			<div id="page-content">
				<?php echo apply_filters('the_content', stripslashes($ql_content['content']?$ql_content['content']:QL_CONTENT_CONTENT)) ?>
			</div>
			<?php if($ql_widgets['email'] || !is_admin()): ?>
			<div id="email" class="<?php echo ($ql_widgets['email'] && !$ql_widgets['mailchimp'])?'':'hidden'; ?>">
				<form action="" method="post" class="newsletter-form">
					<p>
						<input type="text" name="email" value="" placeholder="Signup for email newsletters" size="50" class="email"> 
						<input type="submit" name="submit" value="Submit" id="newsletter-submit" class="btn <?php echo $ql_widgets['email_submit_color']; ?>">
					</p>
				</form>
			</div>
			<div id="mailchimp" class="newsletter-form <?php echo ($ql_widgets['email'] && $ql_widgets['mailchimp'])?'':'hidden'; ?>">
				<?php the_widget('NS_Widget_MailChimp', array('signup_text'=>'Submit')); ?>
			</div>
			<?php endif; ?>
		</section>
		<!-- End Main Content -->
		
		<!-- Footer -->
		<footer class="clearfix">
		
			<!-- Copyright -->
			<div id="copyright">
				<p><?php echo $ql_footer['content']?$ql_footer['content']:QL_FOOTER_CONTENT; ?></p>
			</div>
			<!-- End Copyright -->
			
			<!-- Footer Nav -->
			<!-- End Footer Nav -->
			
			<!-- Social Networks -->
			<nav id="social-networks">
				<ul>
					<li id="social-twitter" class="<?php echo $ql_social['twitter']?'':'hidden'; ?>">
						<a href="<?php echo $ql_social['twitter'] ?>" target="_blank">
							<img src="<?php bloginfo('template_url') ?>/images/twitter.png" alt="Twitter">
						</a>
					</li>
					<li id="social-facebook" class="<?php echo $ql_social['facebook']?'':'hidden'; ?>">
						<a href="<?php echo $ql_social['facebook'] ?>" target="_blank">
							<img src="<?php bloginfo('template_url') ?>/images/facebook.png" alt="Facebook">
						</a>
					</li>
					<li id="social-linkedin" class="<?php echo $ql_social['linkedin']?'':'hidden'; ?>">
						<a href="<?php echo $ql_social['linkedin'] ?>" target="_blank">
							<img src="<?php bloginfo('template_url') ?>/images/linkedin.png" alt="LinkedIn">
						</a>
					</li>
					<li id="social-googleplus" class="<?php echo $ql_social['googleplus']?'':'hidden'; ?>">
						<a href="<?php echo $ql_social['googleplus'] ?>" target="_blank">
							<img src="<?php bloginfo('template_url') ?>/images/googleplus.png" alt="Google+">
						</a>
					</li>
					<li id="social-youtube" class="<?php echo $ql_social['youtube']?'':'hidden'; ?>">
						<a href="<?php echo $ql_social['youtube'] ?>" target="_blank">
							<img src="<?php bloginfo('template_url') ?>/images/youtube.png" alt="YouTube">
						</a>
					</li>
				</ul>
			</nav>
			<!-- End Social Networks -->
			
		</footer>
		<!-- End Footer -->
		
<?php get_footer() ?>
