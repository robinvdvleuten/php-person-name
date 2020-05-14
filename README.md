# PersonName

[![Latest Version on Packagist](https://img.shields.io/packagist/v/webstronauts/person-name.svg?style=flat-square)](https://packagist.org/packages/webstronauts/person-name)
[![Build Status](https://img.shields.io/github/workflow/status/webstronauts/php-person-name/test.svg?style=flat-square)](https://travis-ci.com/webstronauts/php-person-name)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/webstronauts/php-person-name/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/webstronauts/php-person-name)
[![Quality Score](https://img.shields.io/scrutinizer/g/webstronauts/php-person-name.svg?style=flat-square)](https://scrutinizer-ci.com/g/webstronauts/php-person-name)
[![StyleCI](https://github.styleci.io/repos/188848621/shield?branch=master)](https://github.styleci.io/repos/188848621)
[![Total Downloads](https://img.shields.io/packagist/dt/webstronauts/person-name.svg?style=flat-square)](https://packagist.org/packages/webstronauts/person-name)

Presenting names for English-language applications where a basic model of first and last name(s) combined is sufficient. This approach is not meant to cover all possible naming cases, deal with other languages, or even titulations. Just the basics.

## Installation

You can install the package via [Composer](https://getcomposer.org).

```bash
composer require webstronauts/person-name
```

## Usage

``` php
<?php

$name = new PersonName::make('David Heinemeier Hansson')

echo $name->full        // "David Heinemeier Hansson"
echo $name->first       // "David"
echo $name->last        // "Heinemeier Hansson"
echo $name->initials    // "DHH"
echo $name->familiar    // "David H."
echo $name->abbreviated // "D. Heinemeier Hansson"
echo $name->sorted      // "Heinemeier Hansson, David"
echo $name->mentionable // "davidh"
echo $name->possessive  // "David Heinemeier Hansson's"
```

### Laravel

This is an example model which exposes a `name` virtual attribute composed from the `first_name` and `last_name` attributes:

```php
<?php

use Webstronauts\PersonName\PersonName;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'first_name', 'last_name',
    ];

    /**
     * Return a PersonName instance composed from the `first_name` and `last_name` attributes.
     * 
     * @return PersonName
     */
    public function getNameAttribute()
    {
        return new PersonName($this->first_name, $this->last_name);
    }

    /** 
     * Sets the `first_name` and `last_name` attributes from a full name.
     * 
     * @param  string $name
     * @return void
     */
    public function setNameAttribute($name)
    {
        $fullName = PersonName::make($name);
        [$this->first_name, $this->last_name] = $fullName ? [$fullName->first, $fullName->last] : [null, null];
    }
}
```

### Testing

``` bash
composer test
```

## Changelog

Detailed release notes for a given version can be found on [our releases page](https://github.com/webstronauts/php-person-name/releases).

## Credits

As it's just a simple port of Ruby to PHP code. All credits should go to the Basecamp team and their [name_of_person](https://github.com/basecamp/name_of_person) gem.

- [Robin van der Vleuten](https://github.com/robinvdvleuten)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
