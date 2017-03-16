<?php

namespace Rapture\Validator;

use Rapture\Validator\Definition\ValidatorAbstract;

/**
 * Cnp validator
 *
 * @see https://ro.wikipedia.org/wiki/Cod_numeric_personal
 *
 * @package Rapture\Validator
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Cnp extends ValidatorAbstract
{
    const GENDER_MAN   = 1;
    const GENDER_WOMAN = 2;

    const ERROR_NONE    = 0;
    const ERROR_FORMAT  = 1; // length & digits
    const ERROR_GENDER  = 2;
    const ERROR_DAY     = 3;
    const ERROR_MONTH   = 4;
    const ERROR_DATE    = 5;
    const ERROR_STATE   = 6;
    const ERROR_CONTROL = 7;

    protected $message = 'CNP invalid.';

    protected $error = self::ERROR_NONE;

    public function getErrorCode()
    {
        return $this->error;
    }

    /**
     * isValid
     *
     * @param string $cnp
     *
     * @return bool
     */
    public function isValid($cnp)
    {
        if (!preg_match('/^[0-9]{13}$/', $cnp)) {
            $this->error = self::ERROR_FORMAT;
            return false;
        }

        if (!self::getState($cnp)) {
            $this->error = self::ERROR_STATE;
            return false;
        }

        if (self::getBirthDate($cnp)->format('ymd') != substr($cnp, 1, 6)) {
            $this->error = self::ERROR_DATE;
            return false;
        }

        // check control digit
        $multiplier = '279146358279';
        $sum = 0;
        for ($i=0; $i<12; $i++) {
            $sum += $cnp[$i] * $multiplier[$i];
        }
        $cc = ($sum % 11) == 10 ? 1 : ($sum % 11);

        if ($cnp[12] != $cc) {
            $this->error = self::ERROR_CONTROL;
            return false;
        }

        return true;
    }

    /**
     * getBirthDate
     *
     * @param string $cnp
     *
     * @return \DateTime
     */
    public static function getBirthDate($cnp)
    {
        return new \DateTime(self::getBirthYear($cnp) . '-' . self::getBirthMonth($cnp) . '-' . self::getBirthDay($cnp));
    }

    /**
     * getBirthDay
     *
     * @param string $cnp
     *
     * @return int
     */
    public static function getBirthDay($cnp):int
    {
        $day = (int)substr($cnp, 5, 2);

        if ($day < 1 || $day > 31) {
            return 0;
        }

        return $day;
    }

    /**
     * getBirthMonth
     *
     * @param string $cnp
     *
     * @return int
     */
    public static function getBirthMonth($cnp):int
    {
        $month = (int)substr($cnp, 3, 2);

        if ($month < 1 || $month > 12) {
            return 0;
        }

        return $month;
    }

    /**
     * getBirthYear
     *
     * @param string $cnp
     *
     * @return int
     */
    public static function getBirthYear($cnp):int
    {
        return $cnp[0] < 3 ? (int)substr($cnp, 1, 2) + 1900 : (int)substr($cnp, 1, 2) + 2000;
    }

    /**
     * getAge
     *
     * @param string $cnp
     *
     * @return int
     */
    public static function getAge($cnp):int
    {
        $birthDate = self::getBirthDate($cnp);

        return (int)$birthDate->diff(new \DateTime())->format('%y');
    }

    /**
     * getState
     *
     * @param string $cnp
     *
     * @return int
     */
    public static function getState($cnp):int
    {
        $state = (int)substr($cnp, 7, 2);
        if (in_array($state, self::getValidStates())) {
            return $state;
        }

        return 0;
    }

    /**
     * getValidStates
     *
     * @return array
     */
    public static function getValidStates()
    {
        return array_merge(range(1, 47), [51, 52, 54]);
    }

    /**
     * getGender
     *
     * @param string $cnp
     *
     * @return int
     */
    public static function getGender($cnp):int
    {
        if (isset($cnp[0]) && (int)$cnp[0] > 0) {
            return $cnp[0] % 2 == 1 ? self::GENDER_MAN : self::GENDER_WOMAN;
        }

        return 0;
    }
}
