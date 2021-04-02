<?php

namespace OneNsq;

class Client
{
    /**
     * @var resource
     */
    private $conn;

    /**
     * @var Read
     */
    private $read;

    /**
     * @var Write
     */
    private $write;

    private $server_conf = [];

    private $config = [];

    public function __construct($address, $config = [])
    {
        $config       = $config + Protocol::defaultConf();
        $this->config = $config;
        $this->conn   = stream_socket_client($address, $code, $msg, $config['connect_time_out']);
        stream_set_timeout($this->conn, $config['msg_timeout'] / 1000);
        if (!$this->conn) {
            throw new Exception($msg, $code);
        }
        $this->write = new Write($this->conn);
        $this->read  = new Read($this->conn);

        $this->identify($config);
        $ret = $this->read->valFixed();
        if (isset($config['feature_negotiation']) && $config['feature_negotiation']) {
            $this->server_conf = json_decode($ret, true);
        } else {
            $this->isOk($ret);
        }
    }

    private function isOk($ret)
    {
        if ($ret === Protocol::HEARTBEAT) {
            $this->heartBeat();
        } else if ($ret !== Protocol::OK) {
            throw new Exception('identify fail : ' . $ret, Exception::CODE_IDENTIFY_FAIL);
        }
    }

    private function identify($config)
    {
        $this->write->send(Protocol::VERSION);
        $this->write->send(Protocol::COMMAND_IDENTIFY . "\n" .
            Protocol::string(json_encode($config))
        );
    }


    /**
     * @param string $topic
     * @param string $msg
     * @return bool
     * @throws Exception
     */
    public function publish($topic, $msg, $defer = 0)
    {
        if ($defer === 0) {
            $this->write->send(Protocol::COMMAND_PUB . ' ' . $topic . "\n" .
                Protocol::string($msg)
            );
        } else {
            $this->write->send(Protocol::COMMAND_DPUB . ' ' . $topic . ' ' . $defer . "\n" .
                Protocol::string($msg)
            );
        }
        $ret = $this->read->valFixed();
        $this->isOk($ret);
        return true;
    }

    /**
     * @param string $topic
     * @param array $msgs
     */
    public function publishMany($topic, $msgs)
    {
        $str = '';
        foreach ($msgs as $v) {
            $str .= pack('N', strlen($v)) . $v;
        }
        $this->write->send(Protocol::COMMAND_MPUB . ' ' . $topic . "\n" .
            Protocol::string(pack('N', count($msgs)) . $str)
        );
        $ret = $this->read->valFixed();
        $this->isOk($ret);
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function close()
    {
        $this->write->send(Protocol::COMMAND_CLS . "\n");
        $ret = $this->read->valFixed();
        return $ret === 'CLOSE_WAIT';
    }

    /**
     * @param string $secret
     * @return string
     * @throws Exception
     */
    public function auth($secret)
    {
        $this->write->send(Protocol::COMMAND_AUTH . "\n" . Protocol::string($secret));
        $ret = $this->read->valFixed();
        return $ret;
    }

    private function rdy($n)
    {
        $this->write->send(Protocol::COMMAND_RDY . ' ' . $n . "\n");
    }

    private function fin($id)
    {
        $this->write->send(Protocol::COMMAND_FIN . ' ' . $id . "\n");
    }

    private function req($id, $time = 0)
    {
        $this->write->send(Protocol::COMMAND_REQ . ' ' . $id . ' ' . $time . "\n");
    }

    private function heartBeat()
    {
        $this->write->send(Protocol::COMMAND_NOP . "\n");
    }

    public function touch($id)
    {
        $this->write->send(Protocol::COMMAND_TOUCH . ' ' . $id . "\n");
    }

    /**
     * @param string $topic
     * @param string $channel
     * @return Data[]
     * @throws Exception
     */
    public function subscribe($topic, $channel)
    {
        $this->write->send(Protocol::COMMAND_SUB . ' ' . $topic . ' ' . $channel . "\n");
        $ret = $this->read->valFixed();
        $this->isOk($ret);
        $msg_timeout = isset($this->server_conf['msg_timeout']) ?
            $this->server_conf['msg_timeout'] :
            $this->config['msg_timeout'];
        while (true) {
            $this->rdy(1);
            try {
                $ret = $this->read->valFixed();
                if ($ret === Protocol::HEARTBEAT) {
                    $this->heartBeat();
                    continue;
                } else if ($ret instanceof Data) {
                    yield $ret;
                } else {
                    throw new Exception(' sub err msg :' . $ret, Exception::CODE_SUB_ERR);
                }
                $this->fin($ret->id);
            } catch (\Exception $e) {
                if ($ret instanceof Data) {
                    $this->req($ret->id, $msg_timeout * $ret->attempts);
                } else if ($e->getCode() !== Exception::CODE_READ_FAIL) {
                    throw $e;
                }
            }
        }
    }

}