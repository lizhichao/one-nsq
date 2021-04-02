<?php

namespace OneNsq;

/**
 * Class Protocol
 * @package lzc
 */
class Protocol
{
    const VERSION          = '  V2';
    const COMMAND_IDENTIFY = 'IDENTIFY';
    const COMMAND_SUB      = 'SUB';
    const COMMAND_PUB      = 'PUB';
    const COMMAND_MPUB     = 'MPUB';
    const COMMAND_DPUB     = 'DPUB';
    const COMMAND_RDY      = 'RDY';
    const COMMAND_FIN      = 'FIN';
    const COMMAND_REQ      = 'REQ';
    const COMMAND_TOUCH    = 'TOUCH';
    const COMMAND_CLS      = 'CLS';
    const COMMAND_NOP      = 'NOP';
    const COMMAND_AUTH     = 'AUTH';

    const FRAME_TYPE_RESPONSE = 0;
    const FRAME_TYPE_ERROR    = 1;
    const FRAME_TYPE_MESSAGE  = 2;

    const OK         = 'OK';
    const E_INVALID  = 'E_INVALID';
    const E_BAD_BODY = 'E_BAD_BODY';
    const HEARTBEAT  = '_heartbeat_';


    /**
     * @return array
     */
    public static function defaultConf()
    {
        return [
            'connect_time_out'      => 3, // 3s
            'client_id'             => md5(uniqid('one', true)),
            'hostname'              => 'one-nsq',
            'feature_negotiation'   => true,
            'heartbeat_interval'    => 30 * 1000, //  30s
            'output_buffer_size'    => 16 * 1024, // 16k
            'output_buffer_timeout' => 300, // 300ms
            'tls_v1'                => false,
            'snappy'                => false,
            'deflate'               => false,
            'deflate_level'         => 3,
            'sample_rate'           => 0,
            'user_agent'            => 'one-nsq',
            'msg_timeout'           => 60 * 1000 // 60s
        ];
    }

    public static function string($str)
    {
        return pack('N', strlen($str)) . $str;
    }

}

