<?php
require __DIR__ . '/vendor/autoload.php';
$ct = new \OneNsq\Client('tcp://192.168.23.129:4150');
$ct->sub('test', 's1', function (\OneNsq\Data $data) {
    echo 'attempts:' . $data->attempts . PHP_EOL;
    echo 'msg:' . $data->msg . PHP_EOL;
    echo 'time:' . date('Y-m-d H:i:s', $data->timestamp) . PHP_EOL;
    echo 'now:' . date('Y-m-d H:i:s') . PHP_EOL;
    echo "\n --------------- \n";
//
//    if (strpos($data->msg, '错误消息') !== false && $data->attempts === 1) {
//        throw new \Exception('出错了');
//    }

});