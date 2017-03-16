<?php

namespace Rapture\Validator;

use Psr\Http\Message\UploadedFileInterface;
use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * FileSize validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class FileSize extends ValidatorAbstract
{
    protected $message = 'File size must be between :min and :max.';

    protected $options = [
        'min' => 0,
        'max' => 100000
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
        if ($value instanceof UploadedFileInterface) {
            return $value->getSize() > $this->options['min'] && $value->getSize() < $this->options['max'];
        }

        return $value['file']['size'] > $this->options['min'] && $value['file']['size'] < $this->options['max'];
    }
}
