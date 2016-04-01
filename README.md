# Karensi

[![Build Status](https://travis-ci.org/aqlx86/karensi.svg?branch=master)](https://travis-ci.org/aqlx86/karensi)

PHP Library for fixer.io foreign exchange rates and currency conversion.

## Installation

```
> composer.phar require aqlx86/karensi
> composer.phar install
```

## Usage

```
$karensi  = new Karensi\Karensi('USD', 'CAD');
$rates = $k->fetch_rate();
$k->save('./rates/');
```


## Test

```
./bin/phpspec run
```
