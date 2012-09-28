<?php
/**
 * QuickLaunch Theme
 * Personalization Functions File
 *
 * @package QuickLaunch
 * @version 1.0
 * @since 1.0
 * @author brux <brux.romuar@gmail.com>
 */
 
/**
 * Applies the personalization options chosen by the user.
 *
 * @return void
 * @since 1.0
 */
function ql_apply_styles()
{
	$content_padding = get_option('ql-content-padding');
	$content_width = 500 - ($content_padding * 2);
?>

	<!-- Personalization options -->
	<style>
	body {
<?php if ( get_option('ql-bg-color') ): ?>background-color: <?php echo get_option('ql-bg-color') ?>;<?php endif; ?>
<?php if ( get_option('ql-bg-image') ): ?>background-image: url(<?php echo get_option('ql-bg-image') ?>);<?php endif; ?>
			background-position: center 25%;
			background-repeat: no-repeat;
			background-attachment:fixed;
	}
	#wrap {
		padding: <?php echo $content_padding ?>px;
		width: <?php echo $content_width ?>px;
	}
	</style>
	<!-- End Personalization options -->

<?php

}
add_action('wp_head', 'ql_apply_styles');
 
/**
 * Receives and processes files uploaded through the personalization panel.
 *
 * @return void
 * @since 1.0
 */
function ql_upload()
{

	check_ajax_referer('quicklaunch-upload-file', '_wpnonce');

	// Grab file details and content
	$filename = $_FILES['file']['name'];
	$bits = file_get_contents($_FILES['file']['tmp_name']);
	
	// Make sure we have no errors
	if ( $_FILES['file']['error'] != 0 )
	{
		$data = array('msg' => 'Upload Error. Code '. $_FILES['file']['error']);
		$response = new QL_JSONResponse($data, false);
		$response->output();
	}
	
	// Do upload
	$upload = wp_upload_bits($filename, null, $bits);
	
	// Delete the temp file
	@unlink($_FILES['file']['tmp_name']);
	
	// If we have no errors, return the URL of the image as a response 
	if ( $upload['error'] === false )
	{
		$data = array(
			'url' => $upload['url']
		);
		$response = new QL_JSONResponse($data);
		$response->output();
	}
	else
	{
		$data = array('msg' => $upload['error']);
		$response = new QL_JSONResponse($data, false);
		$response->output();
	}

}
add_action('wp_ajax_ql_upload', 'ql_upload');
 
/**
 * Catches and handles the personalization info sent via AJAX.
 *
 * @return void
 * @since 1.0
 */
function ql_save_personalization()
{

	check_ajax_referer('quicklaunch-save-personalization', '_wpnonce');
	
	// Webiste Styles
	$bgcolor = $_POST['bgcolor'];
	$logoimage = $_POST['logoimage'];
	$bgimage = $_POST['bgimage'];
	$centerimage = $_POST['centerimage'];
	$centervideo = $_POST['centervideo'];
	
	$upload_dir = wp_upload_dir();
	
	// If we have a new background image, delete the old one
	$old_bgimage = get_option('ql-bg-image');
	if ( $old_bgimage != $bgimage )
	{
		$old_bgimage = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $old_bgimage);
		@unlink($old_bgimage);
	}
	
	// If we have a new logo image, delete the old one
	$old_logoimage = get_option('ql-logo-image');
	if ( $old_logoimage != $logoimage )
	{
		$old_logoimage = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $old_logoimage);
		@unlink($old_logoimage);
	}
	
	// If we have a new center image, delete the old one
	$old_centerimage = get_option('ql-center-image');
	if ( $old_centerimage != $centerimage )
	{
		$old_centerimage = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $old_centerimage);
		@unlink($old_centerimage);
	}
	
	// Social Network URLs
	$twitter = trim($_POST['twitter']);
	$facebook = trim($_POST['facebook']);
	$linkedin = trim($_POST['linkedin']);
	$googleplus = trim($_POST['googleplus']);
	$youtube = trim($_POST['youtube']);
	$widgets_active = $_POST['widgets_active'];
	
	// Website content
	$title = trim($_POST['title']);
	$desc = trim($_POST['desc']);
	$content = trim($_POST['page-content']);
	$company = trim($_POST['company']);
	
	// Stylings
	$btn_color = $_POST['btn_color'];
	$content_padding = intval($_POST['content_padding']);
	$content_position = $_POST['content_position'];
	$show_email = $_POST['show_email'];
	$rounded_box_background = $_POST['rounded_box_background'];
	$google_font = $_POST['google_font'];
	$box_opacity = $_POST['box_opacity'];
	$text_color = $_POST['text_color'];
	$heading_color = $_POST['heading_color'];
	
	// Save the changes
	update_option('ql-bg-color', $bgcolor);
	update_option('ql-logo-image', $logoimage);
	update_option('ql-bg-image', $bgimage);
	update_option('ql-center-image', $centerimage);
	update_option('ql-twitter-url', $twitter);
	update_option('ql-facebook-url', $facebook);
	update_option('ql-linkedin-url', $linkedin);
	update_option('ql-googleplus-url', $googleplus);
	update_option('ql-youtube-url', $youtube);
	update_option('blogname', $title);
	update_option('blogdescription', $desc);
	update_option('ql-page-content', $content);
	update_option('ql-btn-color', $btn_color);
	update_option('ql-content-padding', $content_padding);
	update_option('ql-company', $company);
	update_option('ql-content-position', $content_position);
	update_option('ql-show-email', $show_email);
	update_option('ql-rounded-box-background', $rounded_box_background);
	update_option('ql-video', $centervideo);
	update_option('ql-google-font', $google_font);
	update_option('ql-widgets-active', $widgets_active);
	update_option('ql-box-opacity', $box_opacity);
	update_option('ql-text-color', $text_color);
	update_option('ql-heading-color', $heading_color);
	
	$data = array('msg' => 'ok');
	$response = new QL_JSONResponse($data);
	$response->output();

}
add_action('wp_ajax_ql_save_personalization', 'ql_save_personalization');

/**
 * Returns TRUE if the user is currently personalizing the site/theme.
 *
 * @return boolean
 * @since 1.0
 */
function ql_is_personalizing()
{

	return defined('QL_PERSONALIZING');

}
 
?>
