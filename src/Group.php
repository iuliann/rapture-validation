<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Group validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Group
{
    const ERROR_MODE_ALL = 0;

    const ERROR_MODE_ONE_ONLY = 1;

    const ERROR_MODE_FIRST_ONLY = 2;

    /**
     * How errors are handled
     *
     * @var int
     */
    protected $mode = self::ERROR_MODE_ALL;

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Validation errors
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Current data to validate
     *
     * @var array
     */
    protected $data = [];

    /**
     * Extra parameters to use with validation
     *
     * @var array
     */
    protected $params = [];

    /**
     * @param array $rules  Group rules
     * @param int   $mode   Error mode
     * @param array $params Extra params
     */
    public function __construct(array $rules = [], $mode = self::ERROR_MODE_ALL, $params = [])
    {
        $this->rules  = $rules;
        $this->mode   = $mode;
        $this->params = $params;
    }

    /**
     * @param array $params Key value pair
     *
     * @return $this
     */
    public function setParams(array $params = [])
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @param string $name Param name
     *
     * @return mixed
     */
    public function getParam($name)
    {
        return $this->params[$name] ?? null;
    }

    /**
     * setRules
     *
     * @param array $rules Validation rules
     *
     * @return $this
     */
    public function setRules(array $rules = [])
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * getRules
     *
     * @param string $scope Scope string
     *
     * @return array
     */
    public function getRules($scope = '*')
    {
        return isset($this->rules[$scope]) ? $this->rules[$scope] : $this->rules;
    }

    /**
     * setErrorMode
     *
     * @param int $mode Error modes
     *
     * @return $this
     */
    public function setErrorMode($mode = self::ERROR_MODE_ALL)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * getErrorMode
     *
     * @return int
     */
    public function getErrorMode()
    {
        return $this->mode;
    }

    /**
     * isValid
     *
     * @param array $data Data to validate
     * @param string $scope Validation scope
     *
     * @return bool
     */
    public function isValid(array $data = [], $scope = '*')
    {
        $this->data = $data;

        $rules = $this->getRules($scope);

        foreach ($rules as $attribute => $attributeRules) {
            $isValid = $this->validate(
                isset($data[$attribute]) ? $data[$attribute] : null,
                $attributeRules,
                $attribute
            );

            if ($isValid == false && $this->mode == self::ERROR_MODE_FIRST_ONLY) {
                break;
            }
        }

        return !$this->hasErrors();
    }

    /**
     * Get data during validation.
     * Use this when you have dependencies between attributes
     * Ex:
     * 'attributeX' => [
     * function ($value, $options, $group) { if ($group->getData()['attributeY'] == 0) return false; ... },
     * null,
     * 'Error message'
     * ]
     *
     * @param string $attribute Attribute name
     * @param mixed $default Default value if attribute is not found
     *
     * @return array
     */
    public function getValueFor($attribute, $default = null)
    {
        return isset($this->data[$attribute])
            ? $this->data[$attribute]
            : $default;
    }

    /**
     * validate
     *
     * @param mixed $value Value to validate
     * @param array $rules Rules to run
     * @param string $attribute Attribute name
     *
     * @return bool
     */
    protected function validate($value, $rules, $attribute)
    {
        foreach ($rules as $rule) {
            $isValid = true;

            if ($rule instanceof ValidatorAbstract) {
                $isValid = $rule->isValid($value);
                $ruleMessage = $rule->getMessage();
                $ruleOptions = [];
                $ruleName = get_class($rule);
            }
            else {
                list($ruleName, $ruleOptions, $ruleMessage) = (array)$rule + [null, [], null];
                $ruleCallback = $ruleName;

                if (is_string($ruleCallback)) {
                    if ($ruleCallback[0] != '\\') {
                        $ruleCallback = '\\Rapture\\Validator\\' . ucfirst($ruleCallback);
                    }

                    /** @var \Rapture\Validator\Definition\ValidatorAbstract $validator */
                    $validator = new $ruleCallback($ruleOptions, $ruleMessage, $this);

                    $isValid = $validator->isValid($value);

                    $ruleMessage = $validator->getMessage();
                }
                elseif ($ruleCallback instanceof \Closure) {
                    $isValid = $ruleCallback($value, $ruleOptions, $this);
                }
            }

            if ($isValid === false && $ruleName != 'optional') {
                $this->addError($ruleMessage, (array)$ruleOptions, $attribute, $value, $ruleName);

                if ($this->mode == self::ERROR_MODE_ONE_ONLY) {
                    return false;
                }
            }
            elseif ($isValid === true && $ruleName == 'optional') {
                return true;
            }
        }

        return !isset($this->errors[$attribute]);
    }

    /**
     * addError
     *
     * @param string $message Error message
     * @param array $options Validation options
     * @param string $attribute Attribute to validate
     * @param mixed $value Validated value
     * @param mixed $ruleName Rule name
     *
     * @return void
     */
    public function addError($message, array $options = [], $attribute = '*', $value = null, $ruleName = '')
    {
        $ruleName = is_string($ruleName) ? $ruleName : 'callback';

        $data = [
            ':attribute' => $attribute,
            ':Attribute' => ucfirst($attribute),
            ':ATTRIBUTE' => strtoupper($attribute),
            ':value' => is_scalar($value) ? $value : '[object]',
            ':rule' => $ruleName
        ];

        foreach ($options as $optionIndex => $optionValue) {
            $data[":{$optionIndex}"] = !is_string($optionValue) ? json_encode($optionValue) : $optionValue;
        }

        $this->errors[$attribute][$ruleName][] = str_replace(array_keys($data), $data, $message);
    }

    /**
     * Manually set errors
     *
     * @param array $errors Errors array
     *
     * @return $this
     */
    public function setErrors(array $errors = [])
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * hasErrors
     *
     * @return bool
     */
    public function hasErrors()
    {
        return (bool)count($this->errors);
    }

    /**
     * getErrorsFor single attribute
     *
     * @param string $attribute Name of the attribute
     *
     * @return array
     */
    public function getErrorsFor($attribute = '')
    {
        return isset($this->errors[$attribute])
            ? $this->errors[$attribute]
            : [];
    }

    /**
     * getErrors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getErrorsIndexed()
    {
        $errors = [];
        foreach ($this->errors as $name => $namedErrors) {
            foreach ($namedErrors as $error) {
                foreach ((array)$error as $singleError) {
                    $errors[$name][] = $singleError;
                }
            }
        }

        return $errors;
    }

    /**
     * Get first error
     *
     * @return string
     */
    public function getError()
    {
        foreach ($this->errors as $attribute => $errors) {
            foreach ($errors as $rule => $ruleErrors) {
                return $ruleErrors[0];
            }
        }

        return '';
    }
}
