<?php
/**
 * QuickLaunch Theme
 * Email Class
 *
 * Represents a subscribed email address in the current WP blog.
 *
 * @package QuickLaunch
 * @version 1.0
 * @since 1.1
 * @author brux <brux.romuar@gmail.com>
 */
class QL_Email
{
	
	/**
	 * ID of the email address in the database.
	 *
	 * @var integer
	 * @since 1.0
	 */
	public $id = null;
	
	/**
	 * The email address.
	 *
	 * @var string
	 * @since 1.0
	 */
	public $email;
	
	/**
	 * The IP Address of the user who registered the email address.
	 *
	 * @var string
	 * @since 1.0
	 */
	public $ip;
	
	/**
	 * The time the email address was registered.
	 *
	 * @var DateTime
	 * @since 1.0
	 */
	public $registered_on;
	
	/**
	 * Empty constructor.
	 *
	 * @since 1.0
	 */
	public function __construct()
	{
	
	}
	
	/**
	 * Returns a string containing all of the registered email addresses in
	 * a CSV format.
	 *
	 * @return string
	 * @since 1.0
	 */
	public static function csv()
	{
	
		$out = '';
		
		$emails = self::get_all();
		foreach ( $emails as $email )
		{
			$out .= $email->email . "\n";
		}
		
		return $out;
	
	}
	
	/**
	 * Checks if the provided email address has already been registered.
	 * Take note that this method does not check if the email address is in a
	 * valid format. Perform validation before calling this method.
	 *
	 * @param string $email email address.
	 * @return boolean
	 * @since 1.0
	 */
	public static function is_registered($email)
	{
		
		global $wpdb;
		
		$table = $wpdb->prefix . 'quicklaunch_emails';
		$query = $wpdb->prepare("SELECT id FROM $table WHERE email=%s", $email);
		
		$row = $wpdb->get_row($query);
		return $row !== null;
		
	}
	
	/**
	 * Returns an array of all of the registered email addresses.
	 *
	 * @return array
	 * @since 1.0
	 */
	public static function get_all()
	{
		
		global $wpdb;
		
		$table = $wpdb->prefix . 'quicklaunch_emails';
		$emails = $wpdb->get_results("SELECT * FROM $table ORDER BY registered_on DESC");
		
		foreach ( $emails as $email )
		{
			$email->registered_on = new DateTime($email->registered_on);
		}
		
		return $emails;
		
	}
	
	/**
	 * Removes email addresses from the databases.
	 *
	 * @param integer $id,.. ID of the email address that will be deleted
	 * @return void
	 * @since 1.0
	 */
	public static function delete()
	{
	
		global $wpdb;
	
		$in_ids = func_get_args();
		$in_ids = implode(',', $in_ids);
		$max_num = func_num_args();
		
		$table = $wpdb->prefix . 'quicklaunch_emails';
		$wpdb->query("DELETE FROM $table WHERE id IN($in_ids) LIMIT $max_num");
	
	}
	
	/**
	 * Checks and validates the fields of this email record. Returns a
	 * multi-dimensional array of validation errors:
	 * array[field][] = 'Error';
	 * array[field2][] = 'Error #2';
	 *
	 * @return array
	 * @since 1.0
	 */
	public function validate()
	{
	
		$errors = array();
	
		if ( empty($this->email) )
		{
			$errors['email'][] = 'Email address is empty';
		}
		else
		{
			if ( ! filter_var($this->email, FILTER_VALIDATE_EMAIL) )
			{
			
				$errors['email'][] = 'Invalid email address.';
				
			}
			else
			{
				
				if ( QL_Email::is_registered($this->email) )
				{
					$errors['email'][] = 'Email address has already been subscribed.';
				}
				
			}
		}
		
		if ( empty($this->ip) )
		{
			$errors['ip'][] = 'IP Address is empty';
		}
		else
		{
			if ( ! filter_var($this->email, FILTER_VALIDATE_EMAIL) )
			{
				$errors['email'][] = 'Invalid IP address.';
			}
		}
		
		return $errors;
	
	}
	
	/**
	 * Syncs the current record to the database. Inserts a new row if ID isn't
	 * specified otherwise updates the record with the same ID as this object.
	 *
	 * @return void
	 * @since 1.0
	 */
	public function save()
	{
		
		global $wpdb;
		
		$table = $wpdb->prefix . 'quicklaunch_emails';
		
		$data = array(
			'email' => $this->email,
			'ip' => $this->ip
		);
		$data_format = array('%s','%s');
		
		if ( $this->id )
		{
			
			$where = array('id' => $this->id);
			$where_format = array('%d');
			
			$result = $wpdb->update($table, $data, $data_format, $where, $where_format);
			
			if ( $result === false )
			{
				throw new Exception('Failed to update database.');
			}
			
		}
		else
		{
			
			$current_date = date('Y-m-d g:i:s');
			$data['registered_on'] = $current_date;
			$this->registered_on = new DateTime($current_date);
			
			$result = $wpdb->insert($table, $data, $data_format);
			
			if ( $result === false )
			{
				throw new Exception('Failed to insert a new row.');
			}
			else
			{
				$this->id = $wpdb->insert_id;
			}
			
		}
		
	}
	
}
?>