<?php
$ip     = $_GET['remote_ip'];
$secret = $_GET['secret'];


$info = [
    'identity'       => 'one-auth1',
    'ttl'            => 36000,
    'Authorizations' => []
];
if ($secret === '123456') {
    $info['Authorizations'][] = [
        'channels'    => ['.*'],
        'topic'       => '.test',
        'permissions' => [
            'subscribe',
            'publish'
        ]
    ];
}
echo json_encode($info);
