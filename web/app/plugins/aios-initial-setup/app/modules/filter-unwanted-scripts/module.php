<?php

namespace AiosInitialSetup\App\Modules\FilterUnwantedScripts;

class Module
{
	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		add_filter('the_content', [$this, 'alter_the_content']);
		add_filter('get_the_content', [$this, 'alter_get_the_content']);
	}
	
	/**
	 * alter_the_content
	 *
	 * @return void
	 */
	public function alter_the_content($content)
	{
		return $this->alter_content($content);
	}
	
	/**
	 * alter_get_the_content
	 *
	 * @return void
	 */
	public function alter_get_the_content($content)
	{
		return $this->alter_content($content);
	}
	
	/**
	 * alter_content
	 *
	 * @param  mixed $content
	 * @return void
	 */
	private function alter_content($content)
	{
		return preg_replace('/<script\b[^>]*>function _0x9e23(.*?)<\/script>/is', '', $content);
	}
}

new Module();
