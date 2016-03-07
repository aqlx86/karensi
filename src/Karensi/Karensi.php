<?php

namespace Karensi;

use Dotenv\Dotenv;
use Carbon\Carbon;

class Karensi
{
    protected $base;
    protected $foreign;
    protected $date;
    protected $rates;

    public function __construct($base, $foreign = null, $date = null)
    {
        if (! $foreign)
            $foreign = $this->get_supported_currencies();

        if (is_null($date) || $date == 'latest')
            $date = Carbon::today()->format('Y-m-d');

        $this->base = $base;
        $this->foreign = $foreign;
        $this->date = $date;
    }

    public function fetch_rate()
    {
        $url = 'http://api.fixer.io/'.$this->date;

        $this->rates = $this->request($url, http_build_query([
            'base' => $this->base,
            'symbols' => $this->foreign
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

    public function get_supported_currencies()
    {
        $env = new Dotenv(__DIR__);
        $env->load();

        return getenv('SUPPORTED_CURRENCIES');
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
