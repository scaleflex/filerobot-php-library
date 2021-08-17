# Scaleflex/Filerobot

This library is a filesystem adapter for Filerobot

# Installation

```bash
composer require scaleflex/filerobot
```

# Bootstrap

Using standard `Scaleflex\Filerobot\FilerobotAdapter;`

``` php
new FilerobotAdapter(api_key)
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
        return $this->filerobot->list_file();
    }
}
```
# Usage
List or search files (Lists all files in your Filerobot container. You can search by providing a search string. Can be recursive.)
``` php
return $this->filerobot->list_file();
```
| Parameter | Default | Description |
| --- | --- | --- |
| query | | (optional) Search pattern matching the file name or metadata. |
| folder | | (optional) Folder to start the search from. Case sensitive. |
| limit | 50 | (optional) Specifies the maximum amount of files to return. [1-4000].|
| offset | 0 | (optional) Specifies the offset of files to display.|
| order | filename,desc | (optional) Order results by: updated_at created_at Append ,asc or ,desc to get ascending or descending results. Example: updated_at,desc|
| mime | |  (optional) Returns only files from specified mimeType.|
| format | | (optional) Allows you to export the results as a csv. Example: format=csv |

Get file details (Retrieving a file's details over UUID requires to authenticate against the API.)
``` php
return $this->filerobot->detail_file($file_uuid);
```

Rename file (Renames the file with the value given in the body.)
``` php
return $this->filerobot->rename_file($file_uuid);
```

Move file (Will move the file to a new folder. The folder will be created if it doesn't already exist.)
``` php
return $this->filerobot->move_file($file_uuid, $folder_uuid);
```

Delete file (Delete a file by its UUID)
``` php
return $this->filerobot->delete_file($file_uuid);
```

Upload one or multiple files

- Method 1 - multipart/form-data request
``` php
return $this->filerobot->upload_file_multipart('/api-demo', public_path('bear.jpg'), 'bear.jpg');
```

- Method 2 - URL(s) of remotely hosted file(s)
``` php
return $thireturn $this->filerobot->upload_file_remote('/api-demo', '[{"name": "new_filename.jpg",  "url":"http://sample.li/boat.jpg" }]');
```

- Method 3 - base64-encoded content
``` php
return $this->filerobot->upload_file_binary('new_image_from_base64.png', 'base64code')
```

List and search folders (Lists all folders in your Filerobot container. You can search by providing a search string. Can be recursive.)
``` php
return $this->filerobot->list_folder();
```
| Parameter | Default | Description |
| --- | --- | --- |
| query | | (optional) Search pattern matching the folder name or metadata. |
| folder | | (optional) Folder to start the search from. Case sensitive. |
| limit | 50 | (optional) Specifies the maximum amount of files to return. [1-4000].|
| offset | 0 | (optional) Specifies the offset of files to display.|
| order | filename,desc | (optional) Order results by: updated_at created_at Append ,asc or ,desc to get ascending or descending results. Example: updated_at,desc|

Get folder details (Gets all information of a folder identified by its folder_uuid. This API will also allow you to check the existence of a folder.)
``` php
return $this->filerobot->detail_folder($folder_uuid);
```

Rename folder (Rename the folder identified by its folder_uuid to the value given in the body)
``` php
return $this->filerobot->rename_folder($folder_uuid, $name_new);
```

Move folder (This api will move a folder, identified by its folder_uuid to a new location (folder) which can be identified by destnation_folder_uuid)
``` php
return $this->filerobot->move_folder($folder_uuid, $destination_folder_uuid);
```

Delete folder (Deleting a folder will recursively delete all sub-folders.)
``` php
return $this->filerobot->delete_folder($folder_uuid);
```

Create folder (This API will create a folder from the value given in the body.)
``` php
return $this->filerobot->create_folder($name)
```

