<?php

namespace App\Exceptions;

use Exception;

class ExecuteException extends Exception
{
    protected $code = 404;
}
