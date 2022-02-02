<?php

namespace App\Exceptions;

class ValidationException extends BaseException
{
    private $details;

    /**
     *
     * @param array $details
     * @return void
     */
    public function __construct($details = [])
    {
        parent::__construct(__CLASS__);
        $this->details = $details;
    }

    public function getDetails()
    {
        return $this->details;
    }
}
