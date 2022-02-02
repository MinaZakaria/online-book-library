<?php

namespace App\Exceptions;

use Exception;

class ErrorTypes
{
    public const ROUTE_NOT_FOUND = 'ROUTE_NOT_FOUND';
    public const METHOD_NOT_ALLOWED = 'METHOD_NOT_ALLOWED';
    public const INPUT_VALIDATION = 'INPUT_VALIDATION';
    public const UNAUTHENTICATED = 'UNAUTHENTICATED';
    public const UNAUTHORIZED = 'UNAUTHORIZED';
    public const ITEM_NOT_FOUND = 'ITEM_NOT_FOUND';
    public const ITEM_NOT_AVAILABLE = 'ITEM_NOT_AVAILABLE';
    public const UNKNOWN = 'UNKNOWN';

    private const MAP = [
        401 => [
            self::UNAUTHENTICATED => 'Authentication failed!',
        ],
        403 => [
            self::UNAUTHORIZED => 'You are not authorized to perform this action!',
        ],
        404 => [
            self::ITEM_NOT_FOUND => 'The item requested is not found',
            self::ROUTE_NOT_FOUND => 'The route requested does not exist',
        ],
        405 => [
            self::METHOD_NOT_ALLOWED => 'This method is not allowed for this route',
        ],
        422 => [
            self::INPUT_VALIDATION => 'Validation failed!',
            self::ITEM_NOT_AVAILABLE => 'Item is not available',
        ],
        520 => [
            self::UNKNOWN => 'Unknown exception',
        ],
    ];

    /**
     * @return string
     */
    public static function title(string $type)
    {
        return self::get($type)['title'];
    }

    /**
     * @return int
     */
    public static function status(string $type)
    {
        return self::get($type)['status'];
    }

    /**
     * @return array
     */
    private static function get(string $type)
    {
        foreach (self::MAP as $status => $types) {
            if (array_key_exists($type, $types)) {
                return [
                    'status' => $status,
                    'title' => $types[$type]
                ];
            }
        }
        throw new Exception('Error Type (' . $type . ') doesn\'t exist');
    }
}
