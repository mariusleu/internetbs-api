<?php namespace Softservlet\Internetbs\Commands;

abstract class AbstractCommand implements CommandInterface
{
	/**
	 * @brief the domain name to register
	 *
	 * @var string
	 */
	protected $data = array();
	
	/**
	 * @brief set a data value 
	 * 
	 * @param string key
	 * @param string value
	 */
	public function setData($key, $value)
	{
		$this->data[$key] = $value;		
	}
	
	/**
	 * @brief get a value from data array by key
	 * 
	 * @param string $key
	 * 
	 * @return mixed value
	 * if the key param is null, then the entire
	 * array with data will be returned
	 */
	public function getData($key = null)
	{
		if(is_null($key)) {
			return $this->data;
		}
		
		if(isset($this->data[$key])) {
			return $this->data[$key];
		}
		
		return null;
	}
		
}