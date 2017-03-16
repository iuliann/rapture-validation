<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * NotEmpty validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class IsEmpty extends ValidatorAbstract
{
    protected $message = 'Value is not empty.';

    /**
     * isValid
     *
     * @param string $value Value to check
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->options['value'] = $value;

        switch (gettype($value)) {
            case 'string':
                return (string)$value === '';
            case 'array':
                return count($value) == 0;
            case 'NULL':
                return true;
            default:
                return false;
        }
    }
}
