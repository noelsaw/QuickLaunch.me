<?php
/**
 * QuickLaunch
 * AJAX JSON Response Class
 *
 * Simple class for responding to AJAX requests through the use of JSON
 *
 * @package QuickLaunch
 * @version 1.0
 * @since 1.0
 * @author brux <brux.romuar@gmail.com>
 */
class QL_JSONResponse
{
	
	/**
	 * Contains additional data/information for the request.
	 *
	 * @var array
	 * @since 1.0
	 */
	protected $data;
	
	/**
	 * Indicates whether the request was successful.
	 *
	 * @var boolean
	 * @since 1.0
	 */
	protected $is_successful;
	
	/**
	 * Constructor. Setups the AJAX response.
	 *
	 * @param array|string|null $data optional data payload. Can either be an array of values or a single "message" string
	 * @param boolean $success optional success status. Set to TRUE to indicate a successful request.
	 * @since 1.0
	 */
	public function __construct($data = null, $success = true)
	{
		
		$this->set_data($data);
		$this->is_successful($success);
		
	}
	
	/**
	 * Returns the data payload.
	 *
	 * @return array
	 * @since 1.0
	 */
	public function get_data()
	{
	
		return $this->data;
	
	}
	
	/**
	 * Sets the contents of the data payload.
	 *
	 * @param array|string|null $data the data payload
	 * @return void
	 * @since 1.0
	 */
	public function set_data($data)
	{
	
		if ( is_string($data) )
		{
			$this->data = array('message' => $data);
		}
		elseif ( $data === null )
		{
			$this->data = array();
		}
		else
		{
			$this->data = $data;
		}
	
	}
	
	/**
	 * Adds a single entry of data to the data array. Will OVERWRITE existing values.
	 *
	 * @param string $key entry key
	 * @param mixed $value the value of the entry
	 * @return void
	 * @since 1.0
	 */
	public function add_data($key, $value)
	{
	
		$this->data[$key] = $value;
	
	}
	
	/**
	 * Sets the "success status" of the request.
	 *
	 * @param boolean $success the success status. Set to TRUE to indicate a successful request.
	 * @return void
	 * @since 1.0
	 */
	public function is_successful($success)
	{
		
		$this->is_successful = (bool) $success;
		
	}
	
	/**
	 * Encodes the response to JSON format.
	 *
	 * @param array|null $data optional data payload that will be merged to the current data.
	 * @return string
	 * @since 1.0
	 */
	public function encode($data = null)
	{
	
		if ( $data === null )
		{
			$data = array();
		}
		
		$data = array_merge($this->data, $data);
		
		if ( $this->is_successful )
		{
			$data['status'] = 'ok';
		}
		else
		{
			$data['status'] = 'error';
		}
		
		$json = json_encode($data);
		
		return $json;
		
	}
	
	/**
	 * Prints out a JSON-encoded format of this response. 
	 * This will TERMINATE the execution of the script.
	 *
	 * @param array|null $data optional data payload that will be merged to the current data.
	 * @return void
	 * @since 1.0 
	 */
	public function output($data = null)
	{
	
		if ( $data === null )
		{
			$data = array();
		}
	
		$response = $this->encode($data);
		echo $response;
		exit;
	
	}
	
	/**
	 * Returns the JSON representation of this response.
	 *
	 * @return string
	 * @since 1.0
	 */
	public function __toString()
	{
	
		return $this->encode();
	
	}
	
} 
?>