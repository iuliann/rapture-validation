<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Length validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Length extends ValidatorAbstract
{
    protected $message = 'Length must be between :min and :max.';

    protected $options = [
        'min' => 0,
        'max' => 10,
        'charset' => 'UTF-8'
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

        $length = mb_strlen($value, $this->options['charset']);

        return $length >= $this->options['min'] && $length <= $this->options['max'];
    }
}
