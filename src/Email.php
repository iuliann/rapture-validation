<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Email validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Email extends ValidatorAbstract
{
    protected $message = 'Invalid email.';

    /**
     * isValid
     *
     * @param string $value Email
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->options['value'] = $value;

        return (bool)filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
