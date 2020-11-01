<?php

declare(strict_types=1);

namespace Dflydev\FigCookies\Modifier;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Dflydev\FigCookies\Modifier\SameSite
 */
final class SameSiteTest extends TestCase
{
    /** @test */
    public function it_can_be_a_Strict_SameSite_modifier(): void
    {
        $strict = SameSite::strict();

        self::assertInstanceOf('Dflydev\FigCookies\Modifier\SameSite', $strict);
        self::assertSame('SameSite=Strict', $strict->asString());
        self::assertEquals(SameSite::strict(), $strict, 'Multiple instances are equivalent');
    }

    /** @test */
    public function it_can_be_a_Lax_SameSite_modifier(): void
    {
        $lax = SameSite::lax();

        self::assertInstanceOf('Dflydev\FigCookies\Modifier\SameSite', $lax);
        self::assertSame('SameSite=Lax', $lax->asString());
        self::assertEquals(SameSite::lax(), $lax, 'Multiple instances are equivalent');
    }

    /** @test */
    public function it_can_be_a_None_SameSite_modifier(): void
    {
        $none = SameSite::none();

        self::assertInstanceOf('Dflydev\FigCookies\Modifier\SameSite', $none);
        self::assertSame('SameSite=None', $none->asString());
        self::assertEquals(SameSite::none(), $none, 'Multiple instances are equivalent');
    }

    /** @test */
    public function lax_strict_and_none_are_different(): void
    {
        self::assertNotEquals(SameSite::lax(), SameSite::strict());
        self::assertNotEquals(SameSite::lax(), SameSite::none());
        self::assertNotEquals(SameSite::strict(), SameSite::none());
    }

    /** @test */
    public function it_can_be_built_from_a_string(): void
    {
        self::assertEquals(SameSite::strict(), SameSite::fromString('Strict'));
        self::assertEquals(SameSite::strict(), SameSite::fromString('strict'));
        self::assertEquals(SameSite::strict(), SameSite::fromString('stRiCt'));
        self::assertEquals(SameSite::lax(), SameSite::fromString('Lax'));
        self::assertEquals(SameSite::lax(), SameSite::fromString('lax'));
        self::assertEquals(SameSite::lax(), SameSite::fromString('lAx'));
        self::assertEquals(SameSite::none(), SameSite::fromString('None'));
        self::assertEquals(SameSite::none(), SameSite::fromString('none'));
        self::assertEquals(SameSite::none(), SameSite::fromString('nOnE'));

        $this->expectException(InvalidArgumentException::class);

        SameSite::fromString('foo');
    }
}
