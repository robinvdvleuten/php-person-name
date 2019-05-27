# PersonName

[![Latest Version on Packagist](https://img.shields.io/packagist/v/webstronauts/person-name.svg?style=flat-square)](https://packagist.org/packages/webstronauts/person-name)
[![Build Status](https://img.shields.io/travis/webstronauts/php-person-name/master.svg?style=flat-square)](https://travis-ci.org/webstronauts/php-person-name)
[![Quality Score](https://img.shields.io/scrutinizer/g/webstronauts/php-person-name.svg?style=flat-square)](https://scrutinizer-ci.com/g/webstronauts/php-person-name)
[![Total Downloads](https://img.shields.io/packagist/dt/webstronauts/person-name.svg?style=flat-square)](https://packagist.org/packages/webstronauts/person-name)

Presenting names for English-language applications where a basic model of first and last name(s) combined is sufficient. This approach is not meant to cover all possible naming cases, deal with other languages, or even titulations. Just the basics.

## Installation

You can install the package via [Composer](https://getcomposer.org).

```bash
composer require webstronauts/person-name
```

## Usage

``` php
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

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

As it's just a simple port of Ruby to PHP code. All credits should go to the Basecamp team and their [name_of_person](https://github.com/basecamp/name_of_person) gem.

- [robinvdvleuten](https://github.com/robinvdvleuten)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
