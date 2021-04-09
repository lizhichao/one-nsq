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
        foreach ($ret1 as $i => $data) {
            if ($data === null) {
                echo 'null ' . PHP_EOL;
                echo "\n --------------- \n";
                continue;
            }
            echo 'attempts:' . $data->attempts . PHP_EOL;
            echo 'msg:' . $data->msg . PHP_EOL;
            echo 'time:' . date('Y-m-d H:i:s', $data->timestamp) . PHP_EOL;
            echo 'now:' . date('Y-m-d H:i:s') . PHP_EOL;
            echo "\n --------------- \n";
            // doing long time
            // 消费队列任务 时间过长的情况 会触发 time out
            sleep(mt_rand(1, 5));
        }
    } catch (\OneNsq\Exception $e) {
        if ($e->getCode() == \OneNsq\Exception::CODE_TIMEOUT) {
            echo $e->getMessage() . PHP_EOL;
            goto timeout;
        }
        throw $e;
    }
}


