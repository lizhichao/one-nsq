<?php

namespace OneNsq;

class Exception extends \Exception
{
    const CODE_WRITE_FAIL    = 100001;
    const CODE_READ_FAIL     = 100002;
    const CODE_IDENTIFY_FAIL = 100003;
    const CODE_MSG_ERR       = 100004;
    const CODE_SUB_ERR       = 100005;
    const CODE_CODE_ERR      = 100006;
    const CODE_TIMEOUT       = 100007;

}