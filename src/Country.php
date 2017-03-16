<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Rapture validator
 *
 * @credits http://country.io
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Country extends ValidatorAbstract
{
    const NAME     = 'name';
    const ISO2     = 'iso2';
    const ISO3     = 'iso3';

    protected $message = 'Invalid country.';

    protected $options = [
        'search' => self::NAME
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

        $countries = $this->getCountries();

        return isset($countries[$this->options['search']][$value]);
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
