<?php namespace Softservlet\Internetbs\Request;

interface RequestInterface
{
	/**
	 * @brief make an request to Internet.BS api
	 * and return an array with requested data
	 *
	 * @param string path
	 * @param Array $data
	 * 
	 * @return Array $response
	 */
	public function make($path, Array $data);

}