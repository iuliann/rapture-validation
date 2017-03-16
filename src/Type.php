<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Type validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Type extends ValidatorAbstract
{
    protected $message = 'Value is not empty.';

    protected $options = [
        'type'  =>  'string'
    ];

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

        return gettype($value) == $this->options['type'];
    }
}
