# Rapture PHP Validation

[![PhpVersion](https://img.shields.io/badge/php-5.4.0-orange.svg?style=flat-square)](#)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](#)

Simple validation for PHP.

## Requirements

- PHP v5.4.0
- php-date, php-filter, php-json, php-mbstring, php-pcre

## Install

```
composer require iuliann/rapture-validation
```

## Quick Start


```php
$validator = new Email();
$validator->isValid('test@gmail.com'); // true
$validator->isValid('test[at]gmail.com'); // false

$validator = new Country(Country::ISO2);
$validator->isValid('us'); // true
$validator->isValid('ux'); // false

// Group Validator
$validator = new Group([
    'email' => [
        ['required'],
        ['email', null, 'Invalid email format :value'],
    ],
    'age' => [
        ['optional'],
        ['number', null, 'Invalid age'],
        ['between', [13, 60], 'You have to be at least :min years old!'],
    ],
    'country' => [
        ['country', [Country::ISO3], 'Invalid ISO3 for country ":value"'],
    ]
]);
$validator->isValid([
    'email' => 'test@gmail.com',
    'age' => 1,
    'country' => 'xxx'
]); // false
$validator->getFirstError(); // Invalid ISO3 for country "xxx"
```

### List of validators

|  Category  |      Validator       | Status |
|------------|----------------------|--------|
| Basic      | Optional             | ✓      |
|            | Required             | ✓      |
|            | NotEmpty             | ✓      |
|            | IsEmpty              | ✓      |
|            | NotNull              | ✓      |
|            | IsNull               | ✓      |
|            | IsTrue               | ✓      |
|            | IsFalse              | ✓      |
|            | Type                 | ✓      |
| String     | Between              | ✓      |
|            | Email                | ✓      |
|            | Length               | ✓      |
|            | Url                  | ✓      |
|            | Regex                | ✓      |
|            | Ip                   |        |
|            | Uuid                 |        |
| Comparison | Between              | ✓      |
|            | EqualTo              | ✓      |
|            | NotEqualTo           | ✓      |
|            | IdenticalTo          | ✓      |
|            | NotIdenticalTo       | ✓      |
|            | LessThan             | ✓      |
|            | LessThanOrEqualTo    | ✓      |
|            | GreaterThan          | ✓      |
|            | GreaterThanOrEqualTo | ✓      |
| Time       | Date                 |        |
|            | DateTime             |        |
|            | Time                 |        |
|            | DateRange            |        |
|            | DateTimeRange        |        |
|            | TimeRange            |        |
| Collection | Choice               |        |
|            | Group                | ✓      |
|            | In                   | ✓      |
|            | Count                |        |
|            | Unique               |        |
|            | PropelUnique         |        |
|            | Language             |        |
|            | Locale               | ✓      |
|            | Country              | ✓      |
| File       | FileSize             | ✓      |
|            | FileType             | ✓      |
| Financial  | Bic                  |        |
|            | CardScheme           |        |
|            | Currency             | ✓      |
|            | Luhn                 |        |
|            | Iban                 |        |
|            | Isbn                 |        |
|            | Issn                 |        |
| Other      | Callback             | ✓      |
|            | Username             | ✓      |
|            | Password             | ✓      |
|            | ReCaptcha            | ✓      |
|            | EmailDomain          | ✓      |
|            | Cnp                  | ✓      |


## About

### Author

Iulian N. `rapture@iuliann.ro`

### Testing

```
cd ./test && phpunit
```

### License

Rapture PHP Validation is licensed under the MIT License - see the `LICENSE` file for details.
