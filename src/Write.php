<?php

namespace OneNsq;

class Write
{
    /**
     * @var resource;
     */
    private $conn;

    public $last_time = 0;

    /**
     * Write constructor.
     * @param resource
     */
    public function __construct($conn)
    {
        $this->conn      = $conn;
        $this->last_time = time();
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
        $this->last_time = time();
        return true;
    }

}