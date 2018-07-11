<?php

namespace Dflydev\FigCookies\Modifier;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Dflydev\FigCookies\Modifier\SameSite
 */
final class SameSiteTest extends TestCase
{
    /** @test */
    public function it_can_be_a_Strict_SameSite_modifier()
    {
        $strict = SameSite::strict();

        self::assertInstanceOf('Dflydev\FigCookies\Modifier\SameSite', $strict);
        self::assertSame('SameSite=Strict', $strict->asString());
        self::assertEquals(SameSite::strict(), $strict, 'Multiple instances are equivalent');
    }

    /** @test */
    public function it_can_be_a_Lax_SameSite_modifier()
    {
        $lax = SameSite::lax();

        self::assertInstanceOf('Dflydev\FigCookies\Modifier\SameSite', $lax);
        self::assertSame('SameSite=Lax', $lax->asString());
        self::assertEquals(SameSite::lax(), $lax, 'Multiple instances are equivalent');
    }

    /** @test */
    public function lax_and_strict_are_different()
    {
        self::assertNotEquals(SameSite::lax(), SameSite::strict());
    }

    /** @test */
    public function it_can_be_built_from_a_string()
    {
        self::assertEquals(SameSite::strict(), SameSite::fromString('Strict'));
        self::assertEquals(SameSite::strict(), SameSite::fromString('strict'));
        self::assertEquals(SameSite::strict(), SameSite::fromString('stRiCt'));
        self::assertEquals(SameSite::lax(), SameSite::fromString('Lax'));
        self::assertEquals(SameSite::lax(), SameSite::fromString('lax'));
        self::assertEquals(SameSite::lax(), SameSite::fromString('lAx'));

        $this->expectException(InvalidArgumentException::class);

        SameSite::fromString('foo');
    }
}
