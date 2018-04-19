<?php

use src\Config;
use src\Curl;
use src\ProductService;

require '_bootstrap.php';

$threads = null;
$seed = null;
if(isset($argv[1],$argv[2])){
    $threads = $argv[1];
    $seed = $argv[2];

    if(!is_numeric($threads) || !is_numeric($seed)){
        throw new Exception('Invalid parameters');
    }
}

$limit = 1000;
$page = 1;
$offset = 0;

$productService = new ProductService();
$curl = new Curl();

$config = Config::load();
$baseUrl = $config['base_url'];
$headers = ['Content-Type: application/json'];

$index = 1;
for(;;){
    $data = $productService->getData($limit, $offset, $threads, $seed);

    if(!count($data)){
        break;
    }

    $message = '### page ' . ($offset+1) . " ###\n";
    echo $message;

    foreach ($data as $row){
        $id = $row['entity_id'];

        $row = $productService->getRow($row);
        $body = json_encode($row);

        $url = $baseUrl . $id;
        $curl->sendPostRequest($url, $body, $headers);

        $message = 'created product #' . $index . ', id: ' . $id . "\n";
        echo $message;

        $index++;
    }

    $page++;
    $offset += $limit;
}