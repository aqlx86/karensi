# karensi

PHP Wrapper for fixer.io

## Installation

```
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
