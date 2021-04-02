<?php

namespace OneNsq;

class Read
{
    /**
     * @var resource;
     */
    private $conn;

    /**
     * Write constructor.
     * @param resource
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function val($n)
    {
        $str = fread($this->conn, $n);
        if ($str === false || !isset($str[0])) {
            throw new Exception('read from fail', Exception::CODE_READ_FAIL);
        }
        if (strlen($str) < $n) {
            $str .= $this->val($n - strlen($str));
        }
        return $str;
    }

    /**
     * @return Data|string
     * @throws Exception
     */
    public function valFixed()
    {
        $l    = unpack('N', $this->val(4))[1];
        $ret  = $this->val($l);
        $code = unpack('N', substr($ret, 0, 4))[1];
        $ret  = substr($ret, 4);
        if ($code === Protocol::FRAME_TYPE_RESPONSE) {
            return $ret;
        } else if ($code === Protocol::FRAME_TYPE_ERROR) {
            throw new Exception('err msg : ' . $ret, Exception::CODE_MSG_ERR);
        } else if ($code === Protocol::FRAME_TYPE_MESSAGE) {
            return new Data($ret);
        } else {
            throw new Exception('undefined code : ' . $code . ' msg:' . $ret, Exception::CODE_CODE_ERR);
        }
    }

}