<?php namespace Softservlet\Internetbs\Request;

use Softservlet\Internetbs\Exceptions\AuthFailedException;
use Softservlet\Internetbs\Exceptions\ConnectionFailedException;

class HttpRequest implements RequestInterface
{
	/**
	 * @brief determines whether we should use
	 * the test api domain for requests
	 * 
	 * @var boolean
	 */
	protected $test = false;
	
	/**
	 * @brief the http api password
	 * 
	 * @var string
	 */
	protected $password;
	
	/**
	 * @brief the http api key
	 * 
	 * @var string
	 */
	protected $apiKey;
	

	public function __construct($apiKey, $password, $test = false)
	{
		$this->apiKey = $apiKey;
		$this->password = $password;
		$this->test = $test;
	}
	
	/**
	 * @brief set the test property
	 * if it is true the api will use the test server
	 * 
	 * @param bool test
	 */
	public function setTest($test)
	{
		$this->test = (bool) $test;
	}
	
	/**
	 * @brief make an http request to internet.bs api
	 *
	 * @param string path
	 * @param Array with GET data
	 * 
	 * @return string response
	 */
	public function make($path, Array $data)
	{		
		$post = array(
			'ApiKey' => $this->apiKey,
			'Password' => $this->password,
			'ResponseFormat' => 'json'
		);	
		$post = array_merge($post, $data);	

		$responseString = null;
		
		//First check if curl extension exists
		if(function_exists('curl_open')) {
			$url = $this->makeUrl($path);
			$responseString = $this->curlRequest($url,$post);
		} else {
			$url = $this->makeUrl($path, $post);
			$responseString = $this->fileGetRequest($url);
		}	
		$response = json_decode($responseString, true);	

		return $response;
	}
	
	/**
	 * @brief make the url for the http request
	 * 
	 * @param string path
	 * 
	 * @return Array get data
	 */
	protected function makeUrl($path, Array $data = array())
	{
		$domain = $this->getDomain() . '/' . trim($path, '/');
		
		if(count($data) == 0) return $domain;	
		
		return $domain . '?' . http_build_query($data);
	}
	
	/**
	 * @brief make an http request using cURL
	 * 
	 * @param string url
	 * 
	 * @return string response
	 */
	protected function curlRequest($url,Array $post)
	{
		$curl = curl_init($url);
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_USERAGENT => 
			'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:25.0) Gecko/20100101 Firefox/25.0'
		));
		
		$response = curl_exec($curl);
			
		if($response == false) {
			throw new ConnectionFailedException(
				sprintf("Http request failed: %s", curl_error($curl))
			);
		}
		
		curl_close($curl);
		return $response;
	}
	
	/**
	 * @brief make an http request using file_get_contents();
	 * 
	 * @param string url
	 * 
	 * @return string response
	 */
	protected function fileGetRequest($url)
	{
		$response = @file_get_contents($url);
		
		if(!$response) {
			throw new ConnectionFailedException(
				'Http request using file_get_contents() failed. Make sure you have openssl enabled.'
			);
		}
		
		return $response;
	}
	
	/**
	 * @brief get the domain where to make the request
	 * 
	 * @param none
	 * 
	 * @return string domain
	 */
	protected function getDomain()
	{
		if($this->test == true) {
			return 'https://testapi.internet.bs';
		} else {
			return 'https://api.internet.bs';
		}
	}
}