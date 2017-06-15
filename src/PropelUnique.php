<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * PropelUnique validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class PropelUnique extends ValidatorAbstract
{
    protected $message = 'Value is not unique.';

    protected $options = [
        'model' => 'User.Email'
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

        list($modelName, $columnName) = explode('.', $this->options['model']);
        $className = APP_NAME . "\\Domain\\Model\\{$modelName}Query";

        return $className::create()->filterBy($columnName, $value)->count() == 0;
    }
}
