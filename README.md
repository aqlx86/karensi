# Karensi

[![Build Status](https://travis-ci.org/aqlx86/karensi.svg?branch=master)](https://travis-ci.org/aqlx86/karensi)

PHP Library for fixer.io foreign exchange rates and currency conversion.

## Installation

```
> composer.phar require aqlx86/karensi
> composer.phar install
```

## Usage

Fetch all
```
$karensi  = new Karensi\Karensi('USD');
$rates = $karensi->fetch_rate();
```

Fetch specific currencies
```
$karensi  = new Karensi\Karensi('USD', ['CAD', 'PHP']);
$rates = $karensi->fetch_rate();
```

Fetch historical rates 
```
$karensi  = new Karensi\Karensi('USD', ['CAD', 'PHP'], '2015-12-28');
$rates = $karensi->fetch_rate();
```

Save fetched rates in json format
```
$karensi->save('./rates/');
```

## Test

```
./bin/phpspec run
```
