<?php

namespace Tests\Unit;

use NickyWoolf\Thrust\NonceGenerator;
use Tests\TestCase;

class NonceGeneratorTest extends TestCase
{
    /** @test */
    function generates_string_30_characters_long()
    {
        $generator = new NonceGenerator();

        $nonce = $generator->generate();

        $this->assertEquals(30, strlen($nonce));
    }

    /** @test */
    function generates_random_nonce()
    {
        $generator = new NonceGenerator();

        $nonceA = $generator->generate();
        $nonceB = $generator->generate();
        $nonceC = $generator->generate();

        $this->assertNotEquals($nonceA, $nonceB);
        $this->assertNotEquals($nonceA, $nonceC);
        $this->assertNotEquals($nonceB, $nonceC);
    }
}