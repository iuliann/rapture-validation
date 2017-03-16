<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Required validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Required extends ValidatorAbstract
{
    protected $message = 'Value is required.';

    /**
     * isValid
     *
     * @param mixed $value Value to check
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->options['value'] = $value;

        return is_array($value)
            ? count($value) > 0
            : strlen((string)$value) > 0;
    }
}
