<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Email disposable list
 *
 * @package Rapture\Validator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class EmailDomain extends ValidatorAbstract
{
    protected $message = 'Invalid email domain';

    protected $options = [
        'whitelist' => []
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

        $domain = substr($value, strpos($value, '@') + 1);

        // check if domain exists
        $dns = checkdnsrr(idn_to_ascii($domain), 'A');
        if ($dns === false) {
            return false;
        }

        // check if domain is not temporary
        if ($domain) {
            if (in_array($domain, $this->getBlackList())) {
                return false;
            }

            $whitelist = $this->getWhitelist();
            if ($whitelist) {
                return in_array($domain, $whitelist);
            }
            else {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    protected function getBlackList():array
    {
        return json_decode(file_get_contents(__DIR__ . '/data/email_disposable.json'), true);
    }

    /**
     * @return array
     */
    protected function getWhitelist():array
    {
        return (array)($this->options['whitelist'] ?? []);
    }
}
