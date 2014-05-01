<?php namespace Softservlet\Internetbs\Commands;

class DomainCreate extends AbstractCommand
{	
	
	public function __construct($domain)
	{
		$this->setData('Domain', strtolower($domain));
	}
	
	/**
	 * @brief get the domain tld
	 * 
	 * @return string tld
	 */
	protected function tld()
	{
		$length = strlen($this->domain);
		
		$last = strrpos($this->domain,'.');
		
		return substr($this->domain, $last, $length - $last);
	}

	/**
	 * @brief set a contact for domain registration
	 * 
	 * @param contact type Registrant | Admin | Technical | Billing
	 * @param contact field
	 * @param contact value
	 * 
	 * @return bool true on success or false on failure
	 */
	public function addContact($type, $field, $value = null)
	{
		$type = (array) $type;
		
		foreach($type as $t) {
			if(is_array($field)) {
				foreach($field as $f => $v) {				
					$key = implode('_', array($t, $f));
					$this->setData($key, $v);
				}
			} else {				
				$key = implode('_', array($t, $field));
				$this->setData($key,$value);	
			}
		}

		return $this;
	}
	
	/**
	 * @brief set the phone number
	 * 
	 * @param string prefix
	 * @param string|int number
	 * 
	 * @return string number
	 */
	public function addPhoneNumber($type, $prefix, $number) 
	{
		$number = preg_replace('/[^0-9]/', '', $number);
		
		$this->addContact($type, 'PhoneNumber', trim($prefix) . '.' . trim($number));
	}

	
	/**
	 * @brief get the command api path
	 * 
	 * @param none
	 * 
	 * @return string path
	 */
	public function getPath()
	{
		return 'Domain/Create';
	}
	
	/**
	 * @brief get the data that should be requested to the api
	 * 
	 * @param none
	 * 
	 * @return Array with data
	 */
	public function run()
	{
		return $this->getData();
	}
}