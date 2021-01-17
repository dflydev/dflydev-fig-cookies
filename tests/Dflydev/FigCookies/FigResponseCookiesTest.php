<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use PHPUnit\Framework\TestCase;

use function strtoupper;

class FigResponseCookiesTest extends TestCase
{
    /**
     * @test
     */
    public function it_gets_cookies() : void
    {
        $response = (new FigCookieTestingResponse());

        $response = $response
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('theme', 'light'))
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('sessionToken', 'ENCRYPTED'))
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('hello', 'world'));

        self::assertEquals(
            'ENCRYPTED',
            FigResponseCookies::get($response, 'sessionToken')->getValue()
        );
    }

    /**
     * @test
     */
    public function it_sets_cookies() : void
    {
        $response = (new FigCookieTestingResponse());

        $response = $response
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('theme', 'light'))
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('sessionToken', 'ENCRYPTED'))
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('hello', 'world'));

        $response = FigResponseCookies::set($response, SetCookie::create('hello', 'WORLD!'));

        self::assertEquals(
            'theme=light,sessionToken=ENCRYPTED,hello=WORLD%21',
            $response->getHeaderLine('Set-Cookie')
        );
    }

    /**
     * @test
     */
    public function it_modifies_cookies() : void
    {
        $response = (new FigCookieTestingResponse());

        $response = $response
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('theme', 'light'))
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('sessionToken', 'ENCRYPTED'))
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('hello', 'world'));

        $response = FigResponseCookies::modify($response, 'hello', static function (SetCookie $setCookie) {
            return $setCookie->withValue(strtoupper($setCookie->getName()));
        });

        self::assertEquals(
            'theme=light,sessionToken=ENCRYPTED,hello=HELLO',
            $response->getHeaderLine('Set-Cookie')
        );
    }

    /**
     * @test
     */
    public function it_removes_cookies() : void
    {
        $response = (new FigCookieTestingResponse());

        $response = $response
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('theme', 'light'))
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('sessionToken', 'ENCRYPTED'))
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, SetCookie::create('hello', 'world'));

        $response = FigResponseCookies::remove($response, 'sessionToken');

        self::assertEquals(
            'theme=light,hello=world',
            $response->getHeaderLine('Set-Cookie')
        );
    }
}
