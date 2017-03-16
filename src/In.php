<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * In validator. If value is empty string it will go with strict comparison.
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class In extends ValidatorAbstract
{
    protected $message = 'Value is not allowed.';

    protected $options = [
        'in' => [],
    ];

    /**
     * isValid
     *
     * @param mixed $value Value to test
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->options['value'] = $value;

        // if value is empty use strict comparison
        return in_array($value, (array)$this->options['in'], strlen($value) == 0);
    }
}
