<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Regex validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Regex extends ValidatorAbstract
{
    protected $message = 'Invalid value.';

    protected $options = [
        'regex' => null
    ];

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

        return (bool)preg_match($this->options['regex'], $value);
    }
}
