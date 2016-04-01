<?php

namespace spec\Karensi;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KarensiSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Karensi\Karensi');
    }

    function let()
    {
        $this->beConstructedWith('USD');
    }

    function load_supported_currencies()
    {
        $this->get_supported_currencies()
            ->shouldReturn("AUD,BGN,BRL,CAD,CHF,CNY,CZK,DKK,GBP,HKD,HRK,HUF,IDR,ILS,INR,JPY,KRW,MXN,MYR,NOK,NZD,PHP,PLN,RON,RUB,SEK,SGD,THB,TRY,USD,ZAR");
    }

    function it_can_set_supported_currencies()
    {
        $currencies = "USD,PHP";
        $this->set_supported_currencies($currencies);
    }

    function it_can_set_and_get_supported_currencies()
    {
        $this->set_supported_currencies('USD,PHP');

        $this->get_supported_currencies()
            ->shouldReturn('USD,PHP');
    }

    function it_can_fetch_rates()
    {
        $this->load_supported_currencies();
        $this->fetch_rate()
            ->shouldHaveKey('base');
    }

    function it_can_fetch_rates_the_save_as_file()
    {
        $this->it_can_set_supported_currencies();
        $this->it_can_fetch_rates();
        $this->save(realpath('./cache').'/');
    }
}
