# karensi

Installation

```
> composer.phar install
```

Usage

```
$karensi  = new Karensi\Karensi('USD', 'CAD');
$rates = $k->fetch_rate();
$k->save('./rates/');
```