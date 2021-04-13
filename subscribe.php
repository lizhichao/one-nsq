<?php
require __DIR__ . '/vendor/autoload.php';

$conf = [
    'msg_timeout'        => 5000,
    'heartbeat_interval' => 1400
];


timeout:{
    $ct   = new \OneNsq\Client('tcp://192.168.23.129:4150', $conf);
    $ret1 = $ct->subscribe('test1', 's1');
    try {
        foreach ($ret1 as $data) {
            if ($data === null) {
                continue;
            }
            echo $data->msg . PHP_EOL;
        }
    } catch (Exception $e) {
        echo '------------------------------------------' . PHP_EOL;
        echo 'code : ' . $e->getCode() . PHP_EOL;
        echo ' msg : ' . $e->getMessage() . PHP_EOL;
        echo '==========================================' . PHP_EOL;
        goto timeout;
    }
}


