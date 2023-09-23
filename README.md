# zipable-dataobjects
create .zip files from dataobjects on the fly with textfile and images


## Installation

> composer require seppzzz/zipable-dataobjects

## Documentation


config.yml :

```
YourDataObject:
  extensions:
    - seppzzz\ZipableDataObjects\ZipableDataObject
```



On your Dataobject :

```
public function createZipableFields(){
		
		$fields = [
			'Textfields' => [
				'Title' => $this->getMyTitle(),
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
