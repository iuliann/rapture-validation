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
class NotEmpty extends ValidatorAbstract
{
    protected $message = 'Value is empty.';

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
                return $value !== '';
            case 'array':
                return (bool)count($value);
            case 'NULL':
                return false;
            default:
                return true;
        }
    }
}
