<?php


namespace OneNsq;


class Data
{
    public $time = '';

    public $attempts = 0;

    public $id = '';

    public $msg = '';

    public $timestamp = 0;

    public function __construct($str)
    {
        $l               = unpack('N', substr($str, 0, 4))[1];
        $r               = unpack('N', substr($str, 4, 4))[1];
        $this->time      = bcadd($l << 32, $r);
        $this->timestamp = intval(bcdiv($this->time, 1000000000));
        $this->attempts  = unpack('n', substr($str, 8, 2))[1];
        $this->id        = substr($str, 10, 16);
        $this->msg       = substr($str, 26);
    }

}