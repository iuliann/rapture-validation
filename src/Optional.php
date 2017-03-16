<?php

namespace Rapture\Validator;

use Rapture\Http\UploadedFile;
use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Use this rule as first rule to skip next if value is allowed to be optional
 * Only checks for empty string or NULL
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Optional extends ValidatorAbstract
{
    protected $message = 'Value is optional.';

    /**
     * Check
     *
     * @param mixed $value Value to check
     *
     * @return bool
     */
    public function isValid($value)
    {
        if ($value instanceof UploadedFile) {
            return $value->getError() == UPLOAD_ERR_NO_FILE;
        }

        return $value === '' || $value === null;
    }
}
