<?php

namespace Tests;

use Currency\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    /** @test */
    public function it_converts_currency_from_one_to_another()
    {
        $converter = new Converter();
        $selling = $converter->from('TRY')->to('USD')->amount(1)->selling();
        $buying = $converter->from('TRY')->to('USD')->amount(1)->buying();

        $this->assertIsFloat($selling);
        $this->assertIsFloat($buying);
    }

    /** @test */
    public function it_does_not_convert_if_from_currency_is_not_set()
    {
        $this->expectException(\Exception::class);

        $converter = new Converter();
        $converter->to('TRY')->amount(1)->selling();
    }

    /** @test */
    public function it_does_not_convert_if_to_currency_is_not_set()
    {
        $this->expectException(\Exception::class);

        $converter = new Converter();
        $converter->from('TRY')->amount(1)->selling();
    }
}
