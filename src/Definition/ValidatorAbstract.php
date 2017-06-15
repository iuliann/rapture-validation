<?php

namespace Rapture\Validator\Definition;
use Rapture\Validator\Group;

/**
 * Base validator abstract class
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
abstract class ValidatorAbstract
{
    protected $message = 'Invalid value.';

    protected $options = [];

    /** @var Group mixed */
    protected $previous;

    /**
     * @param array  $options  Validator options
     * @param string $message  Message
     * @param string $previous Previous validator - use this for bubbling validators - used with Group
     */
    public function __construct($options = [], $message = null, $previous = null)
    {
        if (count($this->options) == 1) {
            $this->options[key($this->options)] = $options;
        }
        else {
            $options = (array)$options;

            // indexed array vs of associated array
            $this->options = isset($options[0])
                ? array_combine(
                    array_keys($this->options),
                    array_values($options) + array_values($this->options)
                )
                : ($options + $this->options);
        }

        $this->message = (string)$message ?: $this->message;
        $this->previous = $previous;
    }

    /**
     * isValid
     *
     * @param mixed $value Value to check
     *
     * @return mixed
     */
    abstract public function isValid($value);

    /**
     * getMessage
     *
     * @return string
     */
    public function getMessage()
    {
        $replacements = [];

        foreach ($this->options as $key => $value) {
            $replacements[":{$key}"] = is_scalar($value) ? $value : '[' . gettype($value) . ']';
        }

        // avoid possible issues with suffixed names
        krsort($replacements);

        return str_replace(array_keys($replacements), $replacements, $this->message);
    }

    /**
     * @param string $name Option name
     *
     * @return mixed
     */
    public function getOption($name)
    {
        return $this->options[$name] ?? null;
    }
}
