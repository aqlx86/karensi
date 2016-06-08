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
        $this->beConstructedWith('USD', ['PHP', 'CAD']);
    }

    function it_can_return_supported_currency_list()
    {
        $supported_currencies = [
            'AUD','BGN','BRL','CAD','CHF','CNY','CZK','DKK','EUR',
            'GBP','HKD','HRK','HUF','IDR','ILS','INR','JPY','KRW',
            'MXN','MYR','NOK','NZD','PHP','PLN','RON','RUB','SEK',
            'SGD','THB','TRY','USD','ZAR'
        ];

        $this->get_supported_currencies()
            ->shouldReturn($supported_currencies);
    }

    function it_can_check_if_currency_is_supported()
    {
        $this->is_supported('USD')
            ->shouldReturn(true);

        $this->is_supported('XXX')
            ->shouldReturn(false);
    }

    function it_can_validate_foreign_currency_if_supported()
    {
        $this->shouldNotThrow('\Exception')
            ->duringValidate();
    }

    function it_can_fetch_rates()
    {
        $this->it_can_validate_foreign_currency_if_supported();

        $this->fetch_rate()
            ->shouldHaveKey('base');
    }

    function it_can_fetch_rates_the_save_as_file()
    {
        $this->it_can_fetch_rates();
        $this->save(realpath('./cache').'/');
    }
}
