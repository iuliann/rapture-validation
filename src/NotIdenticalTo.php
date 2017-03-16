<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Not identical validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class NotIdenticalTo extends ValidatorAbstract
{
    protected $message = 'Value must not be :comparison.';

    protected $options = [
        'comparison' => null
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

        return $value !== $this->options['comparison'];
    }
}
