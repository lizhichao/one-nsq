<?php

require __DIR__ . '/vendor/autoload.php';
$ct = new \OneNsq\Client('tcp://192.168.23.129:4150');

$i = 0;
while (true) {
    $i++;
    $ct->pub('test', '普通消息 msg:' . $i . ' time:' . date('Y-m-d H:i:s'));
    sleep(mt_rand(0, 5));
}

for ($i = 0; $i < 6; $i++) {
    $ct->pub('test', '普通消息 msg:' . $i . ' time:' . date('Y-m-d H:i:s'));
}

for ($i = 0; $i < 3; $i++) {
    $ct->pubMany('test', [
        '批量消息 m-msg:' . $i . '-1 time:' . date('Y-m-d H:i:s'),
        '批量消息 m-msg:' . $i . '-2 time:' . date('Y-m-d H:i:s'),
        '批量消息 m-msg:' . $i . '-3 time:' . date('Y-m-d H:i:s')
    ]);
}

for ($i = 0; $i < 6; $i++) {
    $ct->pub('test', '延迟消息 d-msg:' . $i . ' time:' . date('Y-m-d H:i:s'), ($i + 1) * 1000);
}

for ($i = 0; $i < 3; $i++) {
    $ct->pub('test', '错误消息 e-msg:' . $i . ' time:' . date('Y-m-d H:i:s'), ($i + 1) * 1000);
}

//
//$ct = new \OneNsq\Client('tcp://192.168.23.129:4150');
//$ct->sub('test0', 'c1', function (\OneNsq\Data $data) {
//    echo $data->msg . PHP_EOL;
////    throw new Exception('xxx');
//});
