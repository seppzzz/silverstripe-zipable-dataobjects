<?php

namespace seppzzz\ZipableDataObjects;

use SilverStripe\Control\Controller;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\View\Parsers\ShortcodeParser;
use SilverStripe\View\Parsers\URLSegmentFilter;

use SilverStripe\Dev\Debug;
use SilverStripe\Dev\Backtrace;

class ZipPageController extends \PageController //ContentController
{

	private static $allowed_actions = [ 'downloadZip' ];

	private static $url_handlers = [
		'zip/downloadZip/$object/$id' => 'downloadZip'
	];

	public function downloadZip() {

		$baseUrl = Director::absoluteBaseURL();

		// Create a new ZIP archive
		$zip = new \ZipArchive();

		$file = @tempnam( "tmp", "zip" );

		// Open the ZIP archive for writing
		if ( $zip->open( $file, \ZipArchive::OVERWRITE ) === TRUE ) {
			try {
				
				$do = $this->getRequest()->param( 'object' );
				$id = $this->getRequest()->param( 'id' ); //14;

				$dataObject = $do::get()->byID( $id );
				$niceTitle = $this->generateURLSegment($dataObject->Title);

				$zipableFields = $dataObject->createZipableFields();

				$textFieldsContent = '';

				foreach ( $zipableFields[ 'Textfields' ] as $fieldName => $fieldValue ) {
					// Check if the field name is 'Content'
					if ( $fieldName === 'Content' ) {
						// Parse the Content field using ShortcodeParser
						$fieldValue = ShortcodeParser::get_active()->parse( $fieldValue );
					}

					$fieldValue = strip_tags( $fieldValue );

					// Append the field value to the combined content
					$textFieldsContent .= "{$fieldName}: {$fieldValue}\n\n";
				}

				// Name the text file after the Title field
				$textFileName = $niceTitle . '.txt';

				// Add the combined text fields content to the ZIP archive
				$zip->addFromString( $textFileName, $textFieldsContent );

				foreach ( $zipableFields[ 'Images' ] as $image ) {
					// Get the image URL and content
					$imageUrl = 'http://' . $_SERVER[ 'HTTP_HOST' ] . $image->Url;
					$imageContent = file_get_contents( $imageUrl );

					// Add the image to the ZIP archive with its original filename
					$zip->addFromString( pathinfo( $imageUrl, PATHINFO_BASENAME ), $imageContent );
				}

				// Close the ZIP archive
				$zip->close();

				$nameOfZipArchive = $niceTitle .'.zip'; //"MyCustomName.zip";

				header( 'Content-Type: application/octet-stream' );
				header( 'Content-Disposition: attachment; filename="' . $file . '"' );
				header( 'Content-Length: ' . filesize( $file ) );
				header( 'X-Zip-Name: ' . $nameOfZipArchive );

				readfile( $file );

				// Delete the temporary ZIP file
				unlink( $file );

			} catch ( Exception $e ) {
				// Handle any exceptions here
				echo 'Error: ' . $e->getMessage();
			}
		} else {
			echo 'Failed to create ZIP archive';
		}

	}

	
	public function generateURLSegment($string)
    {
        // Sanitize and beautify the string for a URL segment
        $filter = URLSegmentFilter::create();
        $cleanSegment = $filter->filter($string);

        return $cleanSegment;
    }


}

