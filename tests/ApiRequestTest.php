<?php 

use Softservlet\Internetbs\Api;
use Softservlet\Internetbs\Request\HttpRequest;

class ApiRequestTest extends PHPUnit_Framework_TestCase
{
	public function testRequest()
	{
		$api = new Api(
				new HttpRequest('testapi','testpass',true)
				);

		$response = $api->request('Domain/Check',array(
			'Domain' => 'name.com'
		));

		$this->assertEquals($response['status'],'UNAVAILABLE');
	}
}