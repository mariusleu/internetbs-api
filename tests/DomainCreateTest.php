<?php 

use Softservlet\Internetbs\Api;
use Softservlet\Internetbs\Request\HttpRequest;
use Softservlet\Internetbs\Commands\DomainCreate;

class DomainCreateTest extends PHPUnit_Framework_TestCase
{
	public function testDomainCreate()
	{
		//setup the command
		$command = new DomainCreate('jaservletasd332.com');
		$contacts = array(
			'Registrant',
			'Admin',
			'Technical',
			'Billing'
		);
		 
		$command->addContact($contacts, array(
				'FirstName' => 'Benjamin',
				'LastName' => 'Dawson',
				'Email'	=> 'owner@name.com',
				'Street' => '1865 Shadowmar Drive',
				'CountryCode' => 'RO',
				'PostalCode' => '220099',
				'City' => 'Bucharest'
		));	
		$command->addPhoneNumber($contacts, '+1', '310-716-7152');	
		
		$request = new HttpRequest('testapi','testpass',true);
		
		$api = new Api($request);
		$response = $api->run($command);
		
		var_dump($response);
	}
}