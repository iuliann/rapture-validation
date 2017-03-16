<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Password validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Password extends ValidatorAbstract
{
    const UPPERCASE = 1;
    const LOWERCASE = 2;
    const DIGIT     = 4;
    const SPECIAL   = 8;

    protected $message = 'Pasword must be at least :length characters in length with no spaces and must contain at least one of the following: uppercase letter, lowercase letter, one digit and one special character!';

    protected $options = [
        'length'    => 6,
        'format'    => self::UPPERCASE|self::LOWERCASE|self::DIGIT|self::SPECIAL
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

        if (strlen($value) < $this->options['length']) {
            return false;
        }

        if (strpos($value, ' ') !== false) {
            return false;
        }

        if (($this->options['format'] & self::UPPERCASE) && (!preg_match('/[A-Z]+/', $value))) {
            return false;
        }

        if (($this->options['format'] & self::LOWERCASE) && (!preg_match('/[a-z]+/', $value))) {
            return false;
        }

        if (($this->options['format'] & self::DIGIT) && (!preg_match('/[0-9]+/', $value))) {
            return false;
        }

        if (($this->options['format'] & self::DIGIT) && (!preg_match('/[^0-9a-zA-Z]+/', $value))) {
            return false;
        }

        return true;
    }
}
