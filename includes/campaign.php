<?php
/**
 * QuickLaunch Theme
 * Newsletter Campaign Functions
 *
 * @package QuickLaunch
 * @version 1.0
 * @since 1.1
 * @author brux <brux.romuar@gmail.com>
 */
 
 /**
  * Receives and processes email registrations sent via AJAX.
  *
  * @return void
  * @since 1.0
  */
 function ql_register_email()
 {
 
 	check_ajax_referer('quicklaunch-register-email', '_wpnonce');
 	
 	$email = trim($_POST['email']);
 	
 	// Create our email object
 	$email_obj = new QL_Email();
 	$email_obj->email = $email;
 	$email_obj->ip = $_SERVER['REMOTE_ADDR'];
 	
 	// Validate
 	$errors = $email_obj->validate();
 	if ( ! empty($errors) )
 	{
 		if ( isset($errors['email']) )
 		{
 			$msg = '- '. implode('\n - ', $errors['email']);
 			$data = array('msg' => $msg);
 			$response = new QL_JSONResponse($data, false);
 			$response->output();
 		}
 	}
 	else
 	{
 		$email_obj->save();
 		$response = new QL_JSONResponse();
 		$response->output();
 	}
 
 }
 add_action('wp_ajax_ql_register_email', 'ql_register_email');
 add_action('wp_ajax_nopriv_ql_register_email', 'ql_register_email');
 
 ?>