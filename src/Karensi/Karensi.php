<?php

namespace Karensi;

use Dotenv;
use Carbon\Carbon;

class Karensi
{
    private $supported_currencies = [
        'AUD','BGN','BRL','CAD','CHF','CNY','CZK','DKK','EUR',
        'GBP','HKD','HRK','HUF','IDR','ILS','INR','JPY','KRW',
        'MXN','MYR','NOK','NZD','PHP','PLN','RON','RUB','SEK',
        'SGD','THB','TRY','USD','ZAR'
    ];

    protected $base;
    protected $foreign;
    protected $date;
    protected $rates;

    public function __construct($base, array $foreign = [], $date = null)
    {
        if (! $foreign)
            $foreign = $this->supported_currencies;

        if (is_null($date) || $date == 'latest')
            $date = Carbon::today()->format('Y-m-d');

        $this->base = $base;
        $this->foreign = $foreign;
        $this->date = $date;
    }

    public function get_supported_currencies()
    {
        return $this->supported_currencies;
    }

    public function is_supported($currency)
    {
        return in_array($currency, $this->supported_currencies);
    }

    public function fetch_rate()
    {
        $this->validate();

        $url = 'http://api.fixer.io/'.$this->date;

        $this->rates = $this->request($url, http_build_query([
            'base' => $this->base,
            'symbols' => implode(',', $this->foreign)
        ]));

        return $this->rates;
    }

    public function save($path)
    {
        $path.= $this->rates['date'].DIRECTORY_SEPARATOR;
        $filename = $this->rates['base'].'.json';

        if (! file_exists($path))
            mkdir($path, 0777, true);

        file_put_contents($path . $filename, json_encode($this->rates['rates']));
    }

    public function validate()
    {
        $invalid = array_diff($this->foreign, $this->supported_currencies);

        if (count($invalid))
            throw new \Exception(sprintf('Not supported %s', implode(',', $invalid)));
    }

    private function request($url, $params)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url.'?'.urldecode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $data = curl_exec($ch);

        return json_decode($data, true);
    }
}
