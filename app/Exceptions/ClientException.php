<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ClientException extends Exception
{
    protected Throwable $exception;

    protected int $status;

    protected string $type;

    protected string $title;

    protected array $details;

    public function __construct(Throwable $exception, int $status, string $type, string $title, array $details = [])
    {
        parent::__construct($exception->getMessage());
        $this->exception = $exception;
        $this->status = $status;
        $this->type = $type;
        $this->title = $title;
        $this->details = $details;

        if ($type == ErrorTypes::UNKNOWN) {
            $this->details['message'] = $exception->getMessage();
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $exceptionData = [
            'status' => $this->status,
            'type' => $this->type,
            'title' => $this->title,
            'details' => (object)$this->details
        ];

        if (config('app.debug')) {
            $exceptionData['trace'] = $this->exception->getTrace();
        }

        return $exceptionData;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status;
    }

    public function getException()
    {
        return $this->exception;
    }
}
