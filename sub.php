<?php
require __DIR__ . '/vendor/autoload.php';
$ct  = new \OneNsq\Client('tcp://192.168.23.129:4150');
$ret = $ct->subscribe('test', 's1');
foreach ($ret as $data) {
    echo 'attempts:' . $data->attempts . PHP_EOL;
    echo 'msg:' . $data->msg . PHP_EOL;
    echo 'time:' . date('Y-m-d H:i:s', $data->timestamp) . PHP_EOL;
    echo 'now:' . date('Y-m-d H:i:s') . PHP_EOL;
    echo "\n --------------- \n";
}

