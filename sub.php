<?php
require __DIR__ . '/vendor/autoload.php';

$conf = [
    'msg_timeout'        => 5000,
    'heartbeat_interval' => 1000
];
$ct   = new \OneNsq\Client('tcp://192.168.23.129:4150', $conf);

//
//while (true){
//    $data = $ret2->current();
//    $ret2->next();
//    echo 'msg:' . $data->msg . PHP_EOL;
//}

//$ct2  = new \OneNsq\Client('tcp://192.168.23.129:4150', $conf);
//$ret2 = $ct2->subscribe('test2', 's1');

$ret1 = $ct->subscribe('test1', 's1');
foreach ($ret1 as $i => $data) {
    echoData($data, '1');
//    sleep(3);
}

/**
 * @param \OneNsq\Data $data
 */
function echoData($data, $v)
{
    if ($data === null) {
        echo 'null ' . $v . PHP_EOL;
        echo "\n --------------- \n";
        return;
    }
    echo 'attempts:' . $data->attempts . PHP_EOL;
    echo 'msg:' . $data->msg . PHP_EOL;
    echo 'time:' . date('Y-m-d H:i:s', $data->timestamp) . PHP_EOL;
    echo 'now:' . date('Y-m-d H:i:s') . PHP_EOL;
    echo "\n --------------- \n";
}
