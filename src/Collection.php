<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Same collection validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Collection extends ValidatorAbstract
{
    protected $message = 'Invalid value.';

    protected $options = [
        'rule'  =>  []
    ];

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

        $group = new Group([
            'scalar' => [$this->options['rule']]
        ]);

        foreach ((array)$value as $scalar) {
            if (!$group->isValid(['scalar' => $scalar])) {
                return false;
            }
        }

        return true;
    }
}
