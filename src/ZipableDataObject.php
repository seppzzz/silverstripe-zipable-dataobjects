<?php

namespace seppzzz\ZipableDataObjects;


use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
//use SilverStripe\Versioned\Versioned;
//use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;


class ZipableDataObject extends DataExtension
{

	private static $db = [
        'EnableZip' => 'Boolean'
    ];
	
	public function updateCMSFields(FieldList $fields) 
	{
		
		$fields->insertAfter( CheckboxField::create('EnableZip', 'EnableZip'), 'Title');
		
	}
	
	
	public function createZipableFields(){
		
		$fields = [
			'Textfields' => [
				'Title' => $this->owner->getMyTitle(),
				'Subtitle' => $this->owner->SubTitle,
				'Content' => $this->owner->Content
				],
			'Images' => $this->owner->Images()
		];
		
		return $fields;
		
	}
	
   
    
	
	public function getDownloadLink()
    {
        if ($this->owner->EnableZip) {
			
			$ownerClass = $this->owner->ClassName;
			$ownerID = $this->owner->ID;
            
			$url = Controller::join_links(Director::BaseURL().'zip/downloadZip/' . urlencode($ownerClass) . '/' . $ownerID);
            return $url;
        }
		
        return false;
    }

  
}
