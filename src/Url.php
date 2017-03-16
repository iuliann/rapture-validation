<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * URL validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class URL extends ValidatorAbstract
{
    protected $message = 'Invalid URL.';

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

        return (bool)filter_var($value, FILTER_VALIDATE_URL);
    }
}
