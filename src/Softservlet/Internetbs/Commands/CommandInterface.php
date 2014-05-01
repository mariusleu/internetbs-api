<?php namespace Softservlet\Internetbs\Commands;

interface CommandInterface
{
	/**
	 * @brief get the command api path
	 * 
	 * @param none
	 * 
	 * @return string path
	 */
	public function getPath();
	
	/**
	 * @brief get the data that should be requested to the api
	 * 
	 * @param none
	 * 
	 * @return Array with data
	 */
	public function run();
}