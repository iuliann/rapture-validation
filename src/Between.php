<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Between validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Between extends ValidatorAbstract
{
    protected $message = 'Value must be between :min and :max.';

    protected $options = [
        'min' => 0,
        'max' => 10
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

        return $value >= $this->options['min'] && $value <= $this->options['max'];
    }
}
