<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Locale validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Locale extends ValidatorAbstract
{
    protected $message = 'Value is not a valid locale.';

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

        return strlen($value) == 2
            ? (bool)preg_match("/^{$value}_/m", shell_exec('locale -a'))
            : (bool)preg_match("/^{$value}./m", shell_exec('locale -a'));
    }
}
