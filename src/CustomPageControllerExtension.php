<?php

use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Director;


class CustomPageControllerExtension extends Extension
{
    
	public function onAfterInit()
    {

		$vars = [
			"BaseHref" => Director::absoluteBaseURL(),
		];
		
		Requirements::javascript('vendor/seppzzz/zipable-dataobjects/javascript/FileSaver.js');
		Requirements::javascriptTemplate('vendor/seppzzz/zipable-dataobjects/javascript/zip_xhr.js', $vars);
		
		
    }
	
	
}