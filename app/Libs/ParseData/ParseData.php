<?php
namespace App\Libs\ParseData;

use League\Flysystem\Config;

class ParseData {
    public $baseUrl;

    public function __construct() {
        $this->baseUrl = Config('app.api_url');
    }

    private function getDataFromUrl() {
        # Calling function for data
        $data = json_decode(file_get_contents("$this->baseUrl/detections/"), true);
        foreach ($data as &$info) {
            $info['time'] = date('Y-m-d H:i:s', strtotime($info['time']));
        }

        return $data;
    }

    public function getMainData() {
        return $this->getDataFromUrl();
    }
}
