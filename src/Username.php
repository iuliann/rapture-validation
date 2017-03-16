<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Username validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Username extends ValidatorAbstract
{
    protected $message = 'Invalid username.';

    protected $options = [
        'min' => 4,
        'max' => 20
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

        $min = (int)$this->options['min'] - 1;
        $max = (int)$this->options['max'] - 1;
        return (bool)preg_match("/^[a-z]{1}[a-z0-9_]{{$min},{$max}}$/", $value);
    }
}
