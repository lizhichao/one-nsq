<?php
require __DIR__ . '/vendor/autoload.php';
$ct = new \OneNsq\Client('tcp://192.168.23.129:4150');

//
//while (true){
//    $data = $ret2->current();
//    $ret2->next();
//    echo 'msg:' . $data->msg . PHP_EOL;
//}

$ct2 = new \OneNsq\Client('tcp://192.168.23.129:4150');
$ret2 = $ct2->subscribe('test2', 's1');

$ret1 = $ct->subscribe('test1', 's1');
foreach ($ret1 as $data) {
    echoData($data);
    $data = $ret2->current();
    $ret2->next();
    echoData($data);
}

/**
 * @param \OneNsq\Data $data
 */
function echoData($data)
{
    if ($data === null) {
        echo 'null' . PHP_EOL;
        echo "\n --------------- \n";
        return;
    }
    echo 'attempts:' . $data->attempts . PHP_EOL;
    echo 'msg:' . $data->msg . PHP_EOL;
    echo 'time:' . date('Y-m-d H:i:s', $data->timestamp) . PHP_EOL;
    echo 'now:' . date('Y-m-d H:i:s') . PHP_EOL;
    echo "\n --------------- \n";
}
