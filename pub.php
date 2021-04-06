<?php

require __DIR__ . '/vendor/autoload.php';
$ct = new \OneNsq\Client('tcp://192.168.23.129:4150');

//$ct->auth('12345');

$i = 0;
while (true) {
    $i++;
    $ct->publish('test1', 'test-1:' . $i . ' time:' . date('Y-m-d H:i:s'));
    echo $i.PHP_EOL;
    sleep(mt_rand(0, 5));
}
//
//for ($i = 0; $i < 10000; $i++) {
//    $ct->publish('test2', ' test-2 :' . $i . ' time:' . date('Y-m-d H:i:s'));
//}

//for ($i = 0; $i < 3; $i++) {
//    $ct->publishMany('test', [
//        '批量消息 m-msg:' . $i . '-1 time:' . date('Y-m-d H:i:s'),
//        '批量消息 m-msg:' . $i . '-2 time:' . date('Y-m-d H:i:s'),
//        '批量消息 m-msg:' . $i . '-3 time:' . date('Y-m-d H:i:s')
//    ]);
//}
//
//for ($i = 0; $i < 6; $i++) {
//    $ct->publish('test', '延迟消息 d-msg:' . $i . ' time:' . date('Y-m-d H:i:s'), ($i + 1) * 1000);
//}
//
//for ($i = 0; $i < 3; $i++) {
//    $ct->publish('test', '错误消息 e-msg:' . $i . ' time:' . date('Y-m-d H:i:s'), ($i + 1) * 1000);
//}

//
//$ct = new \OneNsq\Client('tcp://192.168.23.129:4150');
//$ct->sub('test0', 'c1', function (\OneNsq\Data $data) {
//    echo $data->msg . PHP_EOL;
////    throw new Exception('xxx');
//});
