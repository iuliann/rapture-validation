<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Greater than or equal to validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class GreaterThanOrEqualTo extends ValidatorAbstract
{
    protected $message = 'Value must be greater than or equal to :comparison.';

    protected $options = [
        'comparison'=> null
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

        return $value >= $this->options['comparison'];
    }
}
