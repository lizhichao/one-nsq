<?php

namespace OneNsq;

class Write
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

    public function send($str)
    {
        $l = strlen($str);
        if ($l === 0) {
            return false;
        }
        $len = fwrite($this->conn, $str);
        if ($len !== $l) {
            throw new Exception('write fail', Exception::CODE_WRITE_FAIL);
        }
        return true;
    }

}