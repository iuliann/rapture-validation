<?php

use Rapture\Validator\Country;

class ValidatorsTest extends \PHPUnit_Framework_TestCase
{
    public function testPassword()
    {
        $validator = new \Rapture\Validator\Password();

        $this->assertTrue($validator->isValid('Pa5sw0rt!'));

        $this->assertFalse($validator->isValid('Pa5s w0rt!'));  // space
        $this->assertFalse($validator->isValid('pa5sw0rt!'));   // no uppercase
        $this->assertFalse($validator->isValid('PA5SW0RT!'));   // no lowercase
        $this->assertFalse($validator->isValid('Pa5sw0rt'));    // no special
        $this->assertFalse($validator->isValid('Passwort!'));   // no digit
    }

    public function testCurrency()
    {
        $validator = new \Rapture\Validator\Currency();
        $this->assertTrue($validator->isValid('ron'));
        $this->assertFalse($validator->isValid('rom'));
    }

    public function testType()
    {
        $validator = new \Rapture\Validator\Type('string');

        $this->assertTrue($validator->isValid('sss'));
        $this->assertFalse($validator->isValid(0));
    }

    public function testNulls()
    {
        $validator = new \Rapture\Validator\IsNull();

        $this->assertTrue($validator->isValid(null));
        $this->assertFalse($validator->isValid(0));

        $validator = new \Rapture\Validator\NotNull();

        $this->assertTrue($validator->isValid(0));
        $this->assertFalse($validator->isValid(null));
    }

    public function testBooleans()
    {
        $validator = new \Rapture\Validator\IsTrue();

        $this->assertTrue($validator->isValid(true));
        $this->assertFalse($validator->isValid(1));

        $validator = new \Rapture\Validator\IsFalse();

        $this->assertTrue($validator->isValid(false));
        $this->assertFalse($validator->isValid(0));
    }

    public function testIsEmpty()
    {
        $validator = new \Rapture\Validator\IsEmpty();

        $this->assertFalse($validator->isValid('s'));
        $this->assertFalse($validator->isValid(1));
        $this->assertFalse($validator->isValid(0));
        $this->assertFalse($validator->isValid(false));
        $this->assertFalse($validator->isValid(true));

        $this->assertTrue($validator->isValid(null));
        $this->assertTrue($validator->isValid(''));
        $this->assertTrue($validator->isValid([]));
    }

    public function testNotEmpty()
    {
        $validator = new \Rapture\Validator\NotEmpty();

        $this->assertTrue($validator->isValid('s'));
        $this->assertTrue($validator->isValid(1));
        $this->assertTrue($validator->isValid(0));
        $this->assertTrue($validator->isValid(false));
        $this->assertTrue($validator->isValid(true));

        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid(''));
        $this->assertFalse($validator->isValid([]));
    }

    public function testEmailDomain()
    {
        $validator = new \Rapture\Validator\EmailDomain();

        $this->assertTrue($validator->isValid('test@gmail.com'));
        $this->assertFalse($validator->isValid('test@zzz.com'));

        // with whitelist

        $validator = new \Rapture\Validator\EmailDomain(['gmail.com', 'yahoo.com', 'outlook.com', 'zoho.com']);

        $this->assertTrue($validator->isValid('test@zoho.com'));
        $this->assertFalse($validator->isValid('test@mydomain.com'));
    }

    public function testCountry()
    {
        $country = new Country(Country::NAME);

        $this->assertTrue($country->isValid('Romania'));
        $this->assertFalse($country->isValid('România'));

        $country = new Country(Country::ISO2);
        $this->assertTrue($country->isValid('ro'));
        $this->assertFalse($country->isValid('rx'));

        $country = new Country(Country::ISO3);
        $this->assertTrue($country->isValid('rou'));
        $this->assertFalse($country->isValid('rom'));
    }

    public function testBetween()
    {
        $validator = new \Rapture\Validator\Between([10, 120]);

        $this->assertTrue($validator->isValid(100));
        $this->assertFalse($validator->isValid(121));
    }

    public function testCnp()
    {
        $validator = new \Rapture\Validator\Cnp();

        $this->assertTrue($validator->isValid('1921010410024'));
        $this->assertFalse($validator->isValid('1921010410026'));
    }

    public function testEmail()
    {
        $validator = new \Rapture\Validator\Email();

        $this->assertTrue($validator->isValid('valid@gmail.com'));
        $this->assertFalse($validator->isValid('invalid @gmail.com'));
    }

    public function testEqualTo()
    {
        $validator = new \Rapture\Validator\EqualTo(100);

        $this->assertTrue($validator->isValid(100));
        $this->assertTrue($validator->isValid('100'));
        $this->assertFalse($validator->isValid(99));
    }

    public function testGreaterThan()
    {
        $validator = new \Rapture\Validator\GreaterThan(100);

        $this->assertTrue($validator->isValid(101));
        $this->assertFalse($validator->isValid('100'));
        $this->assertFalse($validator->isValid(99));
    }

    public function testGreaterThanOrEqualTo()
    {
        $validator = new \Rapture\Validator\GreaterThanOrEqualTo(100);

        $this->assertTrue($validator->isValid(100));
        $this->assertTrue($validator->isValid('100'));
        $this->assertFalse($validator->isValid(99));
    }

    public function testIdenticalTo()
    {
        $validator = new \Rapture\Validator\IdenticalTo(100);

        $this->assertTrue($validator->isValid(100));
        $this->assertFalse($validator->isValid('100'));
    }

    public function testIn()
    {
        $validator = new \Rapture\Validator\In([10, 20, 30]);

        $this->assertTrue($validator->isValid(10));
        $this->assertTrue($validator->isValid(30));
        $this->assertFalse($validator->isValid(40));
    }

    public function testLength()
    {
        $validator = new \Rapture\Validator\Length([10, 20]);

        $this->assertTrue($validator->isValid('2017-06-01'));
        $this->assertTrue($validator->isValid('2017-08-01 12:12:12'));
        $this->assertFalse($validator->isValid('2017-08-01 12:12:12 UTC'));
    }

    public function testLessThan()
    {
        $validator = new \Rapture\Validator\LessThanOrEqualTo('2017-07-01');

        $this->assertTrue($validator->isValid('2017-06-01'));
        $this->assertFalse($validator->isValid('2017-08-01'));
        $this->assertFalse($validator->isValid('2018'));
    }

    public function testLessThanOrEqualTo()
    {
        $validator = new \Rapture\Validator\LessThanOrEqualTo(10);

        $this->assertTrue($validator->isValid(9));
        $this->assertTrue($validator->isValid(10));
        $this->assertFalse($validator->isValid(11));
    }

    public function testLocale()
    {
        $validator = new \Rapture\Validator\Locale();

        $this->assertTrue($validator->isValid('en'));
        $this->assertTrue($validator->isValid('en_US'));
        $this->assertFalse($validator->isValid('ro_US'));
    }

    public function testNotEqualTo()
    {
        $validator = new \Rapture\Validator\NotEqualTo(2014);

        $this->assertTrue($validator->isValid(2015));
        $this->assertFalse($validator->isValid(2014));
    }

    public function testNotIdenticalTo()
    {
        $validator = new \Rapture\Validator\NotIdenticalTo(2014);

        $this->assertTrue($validator->isValid('2014'));

        $this->assertFalse($validator->isValid(2014));
    }

    // optional
    // recaptcha

    public function testRegex()
    {
        $validator = new \Rapture\Validator\Regex('/^\d+$/');

        $this->assertTrue($validator->isValid('2014'));

        $this->assertFalse($validator->isValid('2014 '));
        $this->assertFalse($validator->isValid('john'));
    }

    public function testRequired()
    {
        $validator = new \Rapture\Validator\Required();

        $this->assertTrue($validator->isValid('http://google.ro/'));

        $this->assertFalse($validator->isValid(null));
        $this->assertFalse($validator->isValid(''));
    }

    public function testUrl()
    {
        $validator = new \Rapture\Validator\URL();

        $this->assertTrue($validator->isValid('http://google.ro/'));

        $this->assertFalse($validator->isValid('google.ro'));
    }

    public function testUsername()
    {
        $validator = new \Rapture\Validator\Username();

        $this->assertTrue($validator->isValid('nickname20'));
        $this->assertTrue($validator->isValid('nickname_20'));
        $this->assertTrue($validator->isValid('nick'));

        $this->assertFalse($validator->isValid('NickName'));
        $this->assertFalse($validator->isValid('nickname 20'));
        $this->assertFalse($validator->isValid('20nickname'));
    }
}
