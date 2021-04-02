nsq https://nsq.io/ client


- install

> composer require lizhichao/one-nsq

```php
$ct = new \OneNsq\Client('tcp://127.0.0.1:4150');

# subscribe 
$ct->subscribe('test', 's2', function (\OneNsq\Data $data) {
    echo 'attempts:' . $data->attempts . PHP_EOL; 
    echo 'msg:' . $data->msg . PHP_EOL;
    echo 'time:' . date('Y-m-d H:i:s', $data->timestamp) . PHP_EOL;
    echo "\n --------------- \n";
//
//    if (strpos($data->msg, '错误消息') !== false && $data->attempts === 1) {
//        throw new \Exception('出错了');
//    }

});


# publish 
for ($i = 0; $i < 6; $i++) {
    $ct->publish('test', 'msg:' . $i . ' time:' . date('Y-m-d H:i:s'));
}

for ($i = 0; $i < 3; $i++) {
    $ct->publishMany('test', [
        'm-msg:' . $i . '-1 time:' . date('Y-m-d H:i:s'),
        'm-msg:' . $i . '-2 time:' . date('Y-m-d H:i:s'),
        'm-msg:' . $i . '-3 time:' . date('Y-m-d H:i:s')
    ]);
}

for ($i = 0; $i < 6; $i++) {
    $ct->publish('test', 'd-msg:' . $i . ' time:' . date('Y-m-d H:i:s'), ($i + 1) * 1000);
}

for ($i = 0; $i < 3; $i++) {
    $ct->publish('test', '错误消息 e-msg:' . $i . ' time:' . date('Y-m-d H:i:s'), ($i + 1) * 1000);
}

```