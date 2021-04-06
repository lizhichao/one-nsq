nsq https://nsq.io/ client


##  install

```shell
composer require lizhichao/one-nsq

```

## example

```php
$ct = new \OneNsq\Client('tcp://127.0.0.1:4150');

//$ct->auth('12345');

// subscribe 

$res = $ct->subscribe('test', 's2');
foreach ($res as $data) 
{
    if ($data === null) {
        echo 'null' . PHP_EOL;
        echo "\n --------------- \n";
        continue;
    }
    echo 'attempts:' . $data->attempts . PHP_EOL; 
    echo 'msg:' . $data->msg . PHP_EOL;
    echo 'time:' . date('Y-m-d H:i:s', $data->timestamp) . PHP_EOL;
    echo "\n --------------- \n";
//    $ct->touch($data->id);

};


// publish 
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


```