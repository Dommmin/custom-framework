<?php

namespace Framework\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class ExistsInDatabaseException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'The :attribute already exists in the database',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => 'The :attribute does not exist in the database',
        ],
    ];
}