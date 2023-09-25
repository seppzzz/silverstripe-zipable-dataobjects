# silverstripe-zipable-dataobjects
create .zip files from dataobjects on the fly with textfile and images


## Requirements

- SilverStripe 4 (tested with 4.11 and up)

## Installation

Installation is supported via composer only

```sh

composer require seppzzz/zipable-dataobjects

```

## Documentation


config.yml :

```
YourDataObject:
  extensions:
    - seppzzz\ZipableDataObjects\ZipableDataObject
```



On your Dataobject :

```
public function createZipableFields()
{
		
	$fields = [
		'Textfields' => [
			'Title' => $this->Title,
			'Subtitle' => $this->SubTitle,
			'Content' => $this->Content
		],
		'Images' => $this->Images()
	];
		
	return $fields;
		
}

```



In your template :

```
<% if $getDownloadLink %>			
	<a href="$getDownloadLink" class="btn btn-primary zipDownloadButton">Download ZIP</a>
<% end_if %>
```
