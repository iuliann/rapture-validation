<?php

namespace Rapture\Validator;

use Rapture\Container\Container;
use Rapture\Http\Client;
use Rapture\Http\Request;
use Rapture\Http\Uri;
use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Google ReCaptcha validator
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class ReCaptcha extends ValidatorAbstract
{
    protected $message = 'Invalid request';

    protected $options = [
        'url'       =>  'https://www.google.com/recaptcha/api/siteverify',
        'secret'    =>  '',
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
        $post   = [
            'secret'    =>  $this->getSecret(),
            'response'  =>  $value
        ];

        $request  = new Request(new Uri($this->options['url']), Request::METHOD_POST, [], [], ['post' => $post]);
        $client   = new Client();
        $response = $client->sendRequest($request);
        $json     = json_decode($response->getBody());

        if (json_last_error() === JSON_ERROR_NONE) {
            return $json->success === true;
        }

        return false;
    }

    public function getSecret()
    {
        return $this->options['secret'] ?: (defined('RECAPTCHA_SECRET') ? RECAPTCHA_SECRET : null);
    }
}
