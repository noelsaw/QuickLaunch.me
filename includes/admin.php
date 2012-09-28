<?php 
/**
 * QuickLaunch Theme
 * Admin Functions File
 *
 * @package QuickLaunch
 * @version 1.1
 * @since 1.0
 * @author brux <brux.romuar@gmail.com>
 */

/**
 * Catches email list export requests and processes them. We catch these requests
 * in a separate function so that we can do a proper header() call without WP
 * doing an output first.
 *
 * @return void
 */
function ql_catch_exports()
{

	if ( is_admin() && basename($_SERVER['PHP_SELF']) == 'admin.php' )
	{
		if ( isset($_GET['export']) )
		{
			
			$format = $_GET['export'];
			if ( $format == 'csv' )
			{
				
				// Write the csv to a temporary file
				$csv = QL_Email::csv();
				$file = fopen(WP_CONTENT_DIR . '/quicklaunch.csv', 'w');
				fwrite($file, $csv);
				fclose($file);
				
				// Redirect the user to the temporary file
				header('Location: '. WP_CONTENT_URL . '/quicklaunch.csv');
				exit;
				
			}
			
		}
		
	}

}
add_action('admin_init', 'ql_catch_exports');

/**
 * Registers and adds the menus in WP admin.
 *
 * @return void
 * @since 1.0
 */
function ql_add_admin_menus()
{

	add_menu_page('QuickLaunch', 'Quicklaunch', 'edit_theme_options', 'ql-designer', 'ql_designer');
	add_submenu_page('ql-designer', 'Edit site', 'Edit site', 'edit_theme_options', 'ql-designer', 'ql_designer');
	add_submenu_page('ql-designer', 'QuickLaunch Email List', 'Email List', 'list_users', 'ql-email-list', 'ql_email_list');

}
add_action('admin_menu', 'ql_add_admin_menus');

/**
 * Callback function for the Designer page in WP Admin. Just redirects the user
 * to the homepage with the personalization panel displayed.
 *
 * @return void
 * @since 1.0
 */
function ql_designer()
{

?>

	<div class="wrap">
		
		<div id="icon-themes" class="icon32"></div>
		<h2>QuickLaunch</h2>
		
		<p>Personalize your QuickLaunch site by launching the designer:</p>
		<p><a href="<?php bloginfo('url') ?>?personalize" class="button-primary">Launch QuickLaunch Designer</a></p>
		
	</div>

<?php

}

/**
 * Generates the admin page that lists the email addresses that subscribed
 * in the current WP blog.
 *
 * @return void
 * @since 1.1
 */
function ql_email_list()
{

	if ( isset($_POST['delete']) && ! empty($_POST['email']) )
	{
		
		call_user_func_array(array('QL_Email', 'delete'), $_POST['email']);
		$msg = 'Emails removed from the subscription list.';
		
	}

	$emails = QL_Email::get_all();

?>

	<div class="wrap">
		
		<div id="icon-users" class="icon32"></div>
		<h2>Email List</h2>
		
		<?php $ql_widgets = get_option('ql_widgets'); if($ql_widgets['mailchimp']): ?>
		<div class="error">
			<p>You are using Mailchimp to collect email subscriptions.</p>
		</div>
		<?php endif; ?>
		
<?php if ( $msg ): ?>
		<div id="setting-error-settings_updated" class="updated settings-error"> 
			<p><strong><?php echo $msg ?></strong></p>
		</div>
<?php endif; ?>
		
		<br>
		
		<form action="<?php admin_url('admin.php') ?>?page=ql-email-list" method="post" id="emails-form">
		
			<table class="widefat fixed emails" cellspacing="0">
				
				<thead>
					<tr>
						<th scope="col" id="cb" class="manage-column column-cb check-column"><input type="checkbox"></th>
						<th scope="col" id="email" class="manage-column column-email">Email</th>
						<th scope="col" id="date" class="manage-column column-date" style="width: 30%">Date</th>
						<th scope="col" id="ip" class="manage-column column-ip" style="width: 20%">IP Address</th>
					</tr>
				</thead>
				
				<tbody>
				
	<?php if ( empty($emails) ): ?>
					<tr>
						<td colspan="4">No email addresses yet. Don't worry someone will register their email soon :)</td>
					</tr>
<?php else: foreach ( $emails as $email ): ?>
					<tr>
						<th scope="row" class="check-column"><input type="checkbox" name="email[]" value="<?php echo $email->id ?>"></th>
						<td><a href="mailto:<?php echo $email->email ?>"><?php echo $email->email ?></a></td>
						<td><?php echo $email->registered_on->format('Y/m/d') ?></td>
						<td><?php echo $email->ip ?></td>
					</tr>
<?php endforeach; endif; ?>
				
				</tbody>
				
				<tfoot>
					<tr>
						<th scope="col" class="manage-column column-cb check-column"><input type="checkbox"></th>
						<th scope="col" class="manage-column column-email">Email</th>
						<th scope="col" class="manage-column column-date">Date</th>
						<th scope="col" class="manage-column column-ip">IP Address</th>
					</tr>
				</tfoot>
				
			</table>
			
			<div class="tablenav bottom">
				<p>
					<input type="submit" name="delete" value="Delete Selected" class="button"> 
					<a href="<?php admin_url('admin.php') ?>?page=ql-email-list&export=csv">Export as CSV</a>
				</p>
			</div>
			
			<script>
			jQuery('#emails-form').submit(function(evt) {
				if (!confirm('Are you sure you want to delete the selected email addresses?') )
				{
					evt.preventDefault();
				}
			});
			</script>
		
		</form>
		
	</div>

<?php

}

?>
