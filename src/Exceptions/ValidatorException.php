<?php

namespace Om30\ESusToolkit\Exceptions;

class ValidatorException extends \Exception
{
    public static function withErrors(array $errors)
    {
        $self = new static();
        $self->errors = $errors;

        return $self;
    }
}
