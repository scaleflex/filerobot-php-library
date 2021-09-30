# PHP library adapter for Filerobot DAM

This PHP library is designed as a filesystem adapter, to use as a base brick easing connection to and operations in [Filerobot](https://www.filerobot.com).

It is tested and compatible with all major PHP frameworks, like Symfony or Laravel, but feel free to make sure it runs smooth on other frameforks like F3 or Yii, and report success or adaptation needed.

As always, you are welcome to [contact us](mailto:hello@scaleflex.com) if you would like to enrich the project.

## Installation instructions

### Installation

Simple installation via Composer
```bash
composer require scaleflex/filerobot
```
![Install Output Laravel](https://assets.scaleflex.com/Projects/Scaleflex+Github/php-filerobot-library/laravel+install.png?vh=c2f259)

Will add under `vendor`

![Install Laravel Vendor](https://assets.scaleflex.com/Projects/Scaleflex+Github/php-filerobot-library/laravel+vendor.png?vh=f76bd3)

### Bootstrap

Using standard `Scaleflex\Filerobot\FilerobotAdapter;`

``` php
new FilerobotAdapter(your_api_key)
```

``` php
<?php
use Scaleflex\Filerobot\FilerobotAdapter;

class Foo {
    protected $filerobot;
    
    public function __construct()
    {
        $this->filerobot = new FilerobotAdapter('fa5fe3303dd34e1da4810915c7c3fd6f');
    }
    
    public function bar () {
        return $this->filerobot->list_file('/api-demo');
    }
}
```
## Usage
### Files operations
#### List or search files
Lists all files in your Filerobot container. You can alternatively search by providing a search string. Can be recursive.
``` php
return $this->filerobot->list_file('/api-demo');
```
| Parameter | Default | Description |
| --- | --- | --- |
| folder | | Folder to start the search from. Case sensitive. |
| query | | (optional) Search pattern matching the file name or metadata. |
| order | filename,desc | (optional) Order results by: updated_at created_at Append ,asc or ,desc to get ascending or descending results. Example: updated_at,desc|
| limit | 50 | (optional) Specifies the maximum number of files to return. [1-4000].|
| offset | 0 | (optional) Specifies the offset of files to display.|
| mime | |  (optional) Returns only files from specified mimeType.|
| format | | (optional) Allows you to export the results as a csv. Example: format=csv |

#### Get file details
Retrieving a file's details over UUID requires to authenticate against the API.
``` php
return $this->filerobot->detail_file($file_uuid);
```

#### Rename file
Renames the file with the value given in the body.
``` php
return $this->filerobot->rename_file($file_uuid, $new_filename);
```

#### Move file
Will move the file to a new folder. The folder will be created if it doesn't already exist.
``` php
return $this->filerobot->move_file($file_uuid, $folder_uuid);
```

#### Delete file
Delete a file using its UUID as reference.
``` php
return $this->filerobot->delete_file($file_uuid);
```

#### Upload one or multiple files
Multiple methods are available to suit different needs

##### - Method 1 - multipart/form-data request
``` php
return $this->filerobot->upload_file_multipart('/api-demo', '/path/bear.jpg', 'bear.jpg');
```

##### - Method 2 - URL(s) of remotely hosted file(s)
``` php
return $this->filerobot->upload_file_remote('/api-demo', '[{"name": "new_filename.jpg",  "url":"http://sample.li/boat.jpg" }]');
```

##### - Method 3 - base64-encoded content
``` php
$image = base64_encode(file_get_contents('path/bear.jpeg'));
return $this->filerobot->upload_file_binary('/folder/new_image_from_base64.png', $image)
```

#### Stream upload file
This method is useful for uploading files larger than 500MB. The content of the request will be streamed into to the storage container
``` php
$photo = fopen('/path/bear.jpg', 'r');
return $this->filerobot->stream_upload_file('/api-demo', $photo, 'bear.jpg');
```

#### Update file metadata
``` php
return $this->filerobot->update_file_metadata($file_uuid, '{"title": {"de_DE": "Boot",  "en_US": "boat"}}');
```

### Folders operations
#### List and search folders 
Lists all folders in your Filerobot container. You can search by providing a search string. Can be recursive.
``` php
return $this->filerobot->list_folder('/api-demo');
```
| Parameter | Default | Description |
| --- | --- | --- |
| folder | | Folder to start the search from. Case sensitive. |
| query | | (optional) Search pattern matching the folder name or metadata. |
| order | filename,desc | (optional) Order results by: updated_at created_at Append ,asc or ,desc to get ascending or descending results. Example: updated_at,desc|
| limit | 50 | (optional) Specifies the maximum number of folders to return. [1-4000].|
| offset | 0 | (optional) Specifies the offset of files to display.|

#### Get folder details
Gets all information of a folder identified by its folder_uuid. This API will also allow you to check the existence of a folder.
``` php
return $this->filerobot->detail_folder($folder_uuid);
```

#### Rename folder
Renames the folder identified by its folder_uuid to the value given in the body
``` php
return $this->filerobot->rename_folder($folder_uuid, $new_foldername);
```

#### Move folder
Will move a folder, identified by its folder_uuid to a new location (folder) which can be identified by destination_folder_uuid.
``` php
return $this->filerobot->move_folder($folder_uuid, $destination_folder_uuid);
```

#### Delete folder
Deletes a folder _and all sub-folders recursively_.
``` php
return $this->filerobot->delete_folder($folder_uuid);
```

#### Create folder
Creates a folder from the value given in the body.
``` php
return $this->filerobot->create_folder($foldername)
```