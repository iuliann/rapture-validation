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
class FileType extends ValidatorAbstract
{
    protected $message = 'Only :types file types allowed.';

    protected $options = [
        'types' => 'image/png,image/jpeg,image/gif'
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
            return in_array($value->getClientMediaType(), explode(',', $this->options['types']));
        }

        return in_array($value, explode(',', $this->options['types']));
    }
}
