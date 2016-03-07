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

    function it_can_load_supported_currencies()
    {
        $this->get_supported_currencies()
            ->shouldReturn("AUD,BGN,BRL,CAD,CHF,CNY,CZK,DKK,GBP,HKD,HRK,HUF,IDR,ILS,INR,JPY,KRW,MXN,MYR,NOK,NZD,PHP,PLN,RON,RUB,SEK,SGD,THB,TRY,USD,ZAR");
    }

    function it_can_fetch_rates()
    {
        $this->it_can_load_supported_currencies();
        $this->fetch_rate();
    }
}
