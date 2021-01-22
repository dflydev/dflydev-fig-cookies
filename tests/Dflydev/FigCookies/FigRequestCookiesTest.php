<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use PHPUnit\Framework\TestCase;

use function strtoupper;

class FigRequestCookiesTest extends TestCase
{
    /**
     * @test
     */
    public function it_gets_cookies(): void
    {
        $request = (new FigCookieTestingRequest())
            ->withHeader(Cookies::COOKIE_HEADER, 'theme=light; sessionToken=RAPELCGRQ; hello=world');

        self::assertEquals(
            'RAPELCGRQ',
            FigRequestCookies::get($request, 'sessionToken')->getValue()
        );
    }

    /**
     * @test
     */
    public function it_sets_cookies(): void
    {
        $request = (new FigCookieTestingRequest())
            ->withHeader(Cookies::COOKIE_HEADER, 'theme=light; sessionToken=RAPELCGRQ; hello=world');

        $request = FigRequestCookies::set($request, Cookie::create('hello', 'WORLD!'));

        self::assertEquals(
            'theme=light; sessionToken=RAPELCGRQ; hello=WORLD%21',
            $request->getHeaderLine('Cookie')
        );
    }

    /**
     * @test
     */
    public function it_modifies_cookies(): void
    {
        $request = (new FigCookieTestingRequest())
            ->withHeader(Cookies::COOKIE_HEADER, 'theme=light; sessionToken=RAPELCGRQ; hello=world');

        $request = FigRequestCookies::modify($request, 'hello', static function (Cookie $cookie) {
            return $cookie->withValue(strtoupper($cookie->getName()));
        });

        self::assertEquals(
            'theme=light; sessionToken=RAPELCGRQ; hello=HELLO',
            $request->getHeaderLine('Cookie')
        );
    }

    /**
     * @test
     */
    public function it_removes_cookies(): void
    {
        $request = (new FigCookieTestingRequest())
            ->withHeader(Cookies::COOKIE_HEADER, 'theme=light; sessionToken=RAPELCGRQ; hello=world');

        $request = FigRequestCookies::remove($request, 'sessionToken');

        self::assertEquals(
            'theme=light; hello=world',
            $request->getHeaderLine('Cookie')
        );
    }
}
