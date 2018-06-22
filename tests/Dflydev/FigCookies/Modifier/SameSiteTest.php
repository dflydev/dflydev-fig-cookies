<?php

namespace Dflydev\FigCookies\Modifier;

use PHPUnit_Framework_TestCase;

/**
 * @covers \Dflydev\FigCookies\Modifier\SameSite
 */
final class SameSiteTest extends PHPUnit_Framework_TestCase
{
    public function testStrict()
    {
        $strict = SameSite::strict();

        self::assertInstanceOf('Dflydev\FigCookies\Modifier\SameSite', $strict);
        self::assertSame('SameSite=Strict', $strict->asString());
        self::assertEquals(SameSite::strict(), $strict, 'Multiple instances are equivalent');
    }

    public function testLax()
    {
        $lax = SameSite::lax();

        self::assertInstanceOf('Dflydev\FigCookies\Modifier\SameSite', $lax);
        self::assertSame('SameSite=Lax', $lax->asString());
        self::assertEquals(SameSite::lax(), $lax, 'Multiple instances are equivalent');
    }

    public function testStrictAndLaxAreDifferent()
    {
        self::assertNotEquals(SameSite::lax(), SameSite::lax());
    }

    public function fromString()
    {
        self::assertEquals(SameSite::strict(), SameSite::fromString('Strict'));
        self::assertEquals(SameSite::strict(), SameSite::fromString('strict'));
        self::assertEquals(SameSite::strict(), SameSite::fromString('stRiCt'));
        self::assertEquals(SameSite::lax(), SameSite::fromString('Lax'));
        self::assertEquals(SameSite::lax(), SameSite::fromString('lax'));
        self::assertEquals(SameSite::lax(), SameSite::fromString('lAx'));

        $this->setExpectedException('InvalidArgumentException');

        SameSite::fromString('foo');
    }
}
