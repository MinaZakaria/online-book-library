<?php

namespace App\Exceptions;

use App\Exceptions\ErrorTypes;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class ApiReporter
{
    public function report(Throwable $exception)
    {
        switch (get_class($exception)) {
            case NotFoundHttpException::class:
                $type = ErrorTypes::ROUTE_NOT_FOUND;
                break;
            case MethodNotAllowedHttpException::class:
                $type = ErrorTypes::METHOD_NOT_ALLOWED;
                break;
            case ValidationException::class:
                $type = ErrorTypes::INPUT_VALIDATION;
                break;
            case AuthenticationException::class:
                $type = ErrorTypes::UNAUTHENTICATED;
                break;
            case AuthorizationException::class:
                $type = ErrorTypes::UNAUTHORIZED;
                break;
            case ItemNotFoundException::class:
                $type = ErrorTypes::ITEM_NOT_FOUND;
                break;
            case ItemNotAvailableException::class:
                $type = ErrorTypes::ITEM_NOT_AVAILABLE;
                break;
            default:
                $type = ErrorTypes::UNKNOWN;
                break;
        }
        $title = ErrorTypes::title($type);
        $status = ErrorTypes::status($type);
        $details = method_exists($exception, 'getDetails') ? $exception->getDetails() : [];

        return new ClientException($exception, $status, $type, $title, $details);
    }
}
