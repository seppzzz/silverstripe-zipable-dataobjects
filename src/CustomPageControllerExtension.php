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
		
		// Ensure that jQuery is loaded and use noConflict mode
		//Requirements::javascript('https://code.jquery.com/jquery-3.6.0.min.js', ['defer' => true]);
		//Requirements::customScript('jQuery.noConflict();', 'jQueryNoConflict');
		
		Requirements::javascript('silverstripe/admin:client/dist/js/i18n.js');
		Requirements::add_i18n_javascript('vendor/seppzzz/zipable-dataobjects/javascript/lang');
		

		Requirements::javascript('vendor/seppzzz/zipable-dataobjects/javascript/FileSaver.js');
		Requirements::javascriptTemplate('vendor/seppzzz/zipable-dataobjects/javascript/zip_xhr.js', $vars);

		
    }
	
	
}