<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * NotNull validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class NotNull extends ValidatorAbstract
{
    protected $message = 'Value is null.';

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

        return $value !== null;
    }
}
