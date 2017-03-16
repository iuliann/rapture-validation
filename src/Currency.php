<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Currency validator
 *
 * @credits http://country.io
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Currency extends ValidatorAbstract
{
    protected $message = 'Invalid currency.';

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

        $countries = $this->getCountries();

        return isset($countries['curr'][$value]);
    }

    /**
     * getCountries
     *
     * @return array
     */
    protected function getCountries()
    {
        return json_decode(file_get_contents(__DIR__ . '/data/countries.json'), true);
    }
}
