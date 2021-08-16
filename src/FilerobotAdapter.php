<?php

namespace Scaleflex\Filerobot;

use Illuminate\Support\Facades\Http;

class FilerobotAdapter
{
    private $key;

    private $api_file = 'https://api.filerobot.com/fdocs/v4/files';

    private $api_folder = 'https://api.filerobot.com/fdocs/v4/folders';

    /**
     * FilerobotAdapter constructor.
     * @param $folder
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * List file and search file by query string
     *
     * @param string $query
     * @param int $limit
     * @param int $offset
     * @param string $order
     * @param string $mime
     * @param string $format
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     */
    public function list_file(string $query = '', string $folder = '', int $limit = 50, int $offset = 0, string $order = 'filename,desc', string $mime = '', string $format = '')
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->get($this->api_file, [
            'folder' => $folder,
            'q'      => $query,
            'limit'  => $limit,
            'offset' => $offset,
            'order'  => $order,
            'mime'   => $mime,
            'format' => $format
        ])->json();
    }

    /**
     * Detail file
     *
     * @param string $file_uuid
     * @return array|mixed
     */
    public function detail_file(string $file_uuid)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->get($this->api_file . '/' . $file_uuid)->json();
    }

    /**
     * Rename file
     * @param string $file_uuid
     * @param string $name_new
     * @return array|mixed
     */
    public function rename_file(string $file_uuid, string $name_new)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->patch($this->api_file . '/' . $file_uuid, [
            'name' => $name_new
        ])->json();
    }

    /**
     * Move file
     * @param string $file_uuid
     * @param string $folder_uuid
     * @return array|mixed
     */
    public function move_file(string $file_uuid, string $folder_uuid)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->put($this->api_file . '/' . $file_uuid . '/folders/' . $folder_uuid)->json();
    }

    /**
     * Delete file
     * @param string $file_uuid
     * @return array|mixed
     */
    public function delete_file(string $file_uuid)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->delete($this->api_file . '/' . $file_uuid)->json();
    }

    /**
     * Upload file by multipart
     *
     * @param string $folder
     * @param string $path
     * @param string $filename
     * @return array|mixed
     */
    public function upload_file_multipart(string $folder, string $path, string $filename)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'multipart/form-data; boundary=---011000010111000001101001'
        ])->attach(
            'attachment',
            file_get_contents($path),
            $filename
        )->post($this->api_file, [
            'folder' => $folder
        ]);
    }

    /**
     * Upload file by remote
     *
     * @param string $folder
     * @param string $files_urls
     * @return array|mixed
     */
    public function upload_file_remote(string $folder, string $files_urls)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->post($this->api_file . '?folder=' . $folder, [
            'files_urls' => json_decode($files_urls)
        ]);
    }


    /**
     * Upload file by base64
     *
     * @param string $folder
     * @param string $files_urls
     * @return array|mixed
     */
    public function upload_file_binary(string $name, string $data)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->post($this->api_file, [
            'name'        => $name,
            'data'        => $data,
            'postactions' => 'decode_base64'
        ]);
    }

    /**
     * List folder
     *
     * @param string $query
     * @param string $folder
     * @param int $limit
     * @param int $offset
     * @param string $order
     * @return array|mixed
     */
    public function list_folder(string $query = '', string $folder = '', int $limit = 50, int $offset = 0, string $order = 'filename,desc')
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->get($this->api_folder, [
            'folder' => $folder,
            'q'      => $query,
            'limit'  => $limit,
            'offset' => $offset,
            'order'  => $order
        ])->json();
    }

    /**
     * Detail folder
     *
     * @param string $file_uuid
     * @return array|mixed
     */
    public function detail_folder(string $folder_uuid)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->get($this->api_folder . '/' . $folder_uuid)->json();
    }

    /**
     * Rename folder
     * @param string $folder_uuid
     * @param string $name_new
     * @return array|mixed
     */
    public function rename_folder(string $folder_uuid, string $name_new)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->patch($this->api_folder . '/' . $folder_uuid, [
            'name' => $name_new
        ])->json();
    }

    /**
     * Move folder
     * @param string $folder_uuid
     * @param string $destination_folder_uuid
     * @return array|mixed
     */
    public function move_folder(string $folder_uuid, string $destination_folder_uuid)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->put($this->api_folder . '/' . $folder_uuid . '/folders/' . $destination_folder_uuid)->json();
    }

    /**
     * Delete folder
     * @param string $folder_uuid
     * @return array|mixed
     */
    public function delete_folder(string $folder_uuid)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->delete($this->api_folder . '/' . $folder_uuid)->json();
    }

    /**
     * Create folder
     * @param string $name
     * @return array|mixed
     */
    public function create_folder(string $name)
    {
        return Http::withHeaders([
            'X-Filerobot-Key' => $this->key,
            'Content-Type'    => 'application/json'
        ])->post($this->api_folder, [
            'name' => $name
        ])->json();
    }
}
