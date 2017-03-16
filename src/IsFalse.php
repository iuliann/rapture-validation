<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * IsFalse validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class IsFalse extends ValidatorAbstract
{
    protected $message = 'Value is not false.';

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

        return $value === false;
    }
}
