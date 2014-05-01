<?php namespace Softservlet\Internetbs;

use Softservlet\Internetbs\Request\RequestInterface;
use Softservlet\Internetbs\Commands\CommandInterface;

class Api
{
	/**
	 * @brief the request object
	 * 
	 * @var RequestInterface
	 */
	protected $request;
	
	public function __construct(RequestInterface $request)
	{
		$this->request = $request;
	}
	
	public function run(CommandInterface $command)
	{
		return $this->request($command->getPath(), $command->run());	
	}
	
	public function request($path, Array $data)
	{
		return $this->request->make($path, $data);
	}
}