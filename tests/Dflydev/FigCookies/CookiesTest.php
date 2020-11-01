<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

use function str_rot13;

class CookiesTest extends TestCase
{
    private const INTERFACE_PSR_HTTP_MESSAGE_REQUEST = RequestInterface::class;

    /**
     * @param Cookie[] $expectedCookies
     *
     * @test
     * @dataProvider provideCookieStringAndExpectedCookiesData
     */
    public function it_creates_from_request(string $cookieString, array $expectedCookies): void
    {
        /** @var RequestInterface|MockObject $request */
        $request = $this->createMock(self::INTERFACE_PSR_HTTP_MESSAGE_REQUEST);
        $request->expects(self::once())->method('getHeaderLine')->with(Cookies::COOKIE_HEADER)->willReturn($cookieString);

        $cookies = Cookies::fromRequest($request);

        self::assertEquals($expectedCookies, $cookies->getAll());
    }

    /**
     * @param Cookie[] $expectedCookies
     *
     * @test
     * @dataProvider provideCookieStringAndExpectedCookiesData
     */
    public function it_creates_from_cookie_string(string $cookieString, array $expectedCookies): void
    {
        $cookies = Cookies::fromCookieString($cookieString);

        self::assertEquals($expectedCookies, $cookies->getAll());
    }

    /**
     * @param Cookie[] $expectedCookies
     *
     * @test
     * @dataProvider provideCookieStringAndExpectedCookiesData
     */
    public function it_knows_which_cookies_are_available(string $cookieString, array $expectedCookies): void
    {
        $cookies = Cookies::fromCookieString($cookieString);

        foreach ($expectedCookies as $expectedCookie) {
            self::assertTrue($cookies->has($expectedCookie->getName()));
        }

        self::assertFalse($cookies->has('i know this cookie does not exist'));
    }

    /**
     * @test
     * @dataProvider provideGetsCookieByNameData
     */
    public function it_gets_cookie_by_name(string $cookieString, string $cookieName, Cookie $expectedCookie): void
    {
        $cookies = Cookies::fromCookieString($cookieString);

        self::assertEquals($expectedCookie, $cookies->get($cookieName));
    }

    /**
     * @test
     */
    public function it_sets_overrides_and_removes_cookie(): void
    {
        $cookies = new Cookies();

        $cookies = $cookies->with(Cookie::create('theme', 'blue'));

        self::assertEquals('blue', $cookies->get('theme')->getValue());

        $cookies = $cookies->with(Cookie::create('theme', 'red'));

        self::assertEquals('red', $cookies->get('theme')->getValue());

        $cookies = $cookies->without('theme');

        self::assertFalse($cookies->has('theme'));
    }

    /**
     * @test
     */
    public function it_renders_new_cookies_into_empty_cookie_header(): void
    {
        $cookies = (new Cookies())
            ->with(Cookie::create('theme', 'light'))
            ->with(Cookie::create('sessionToken', 'abc123'));

        $originalRequest = new FigCookieTestingRequest();
        $request         = $cookies->renderIntoCookieHeader($originalRequest);

        self::assertNotEquals($request, $originalRequest);

        self::assertEquals('theme=light; sessionToken=abc123', $request->getHeaderLine(Cookies::COOKIE_HEADER));
    }

    /**
     * @test
     */
    public function it_renders_added_and_removed_cookies_header(): void
    {
        $cookies = Cookies::fromCookieString('theme=light; sessionToken=abc123; hello=world')
            ->with(Cookie::create('theme', 'blue'))
            ->without('sessionToken')
            ->with(Cookie::create('who', 'me'));

        $originalRequest = new FigCookieTestingRequest();
        $request         = $cookies->renderIntoCookieHeader($originalRequest);

        self::assertNotEquals($request, $originalRequest);

        self::assertEquals('theme=blue; hello=world; who=me', $request->getHeaderLine(Cookies::COOKIE_HEADER));
    }

    /**
     * @test
     */
    public function it_gets_cookie_value_from_request(): void
    {
        // Example of accessing a cookie value.
        // Simulate a request coming in with several cookies.
        $request = (new FigCookieTestingRequest())
            ->withHeader(Cookies::COOKIE_HEADER, 'theme=light; sessionToken=RAPELCGRQ; hello=world');

        $theme = Cookies::fromRequest($request)->get('theme')->getValue();

        self::assertEquals('light', $theme);
    }

    /**
     * @test
     */
    public function it_gets_and_updates_cookie_value_on_request(): void
    {
        // Example of naive cookie decryption middleware.
        //
        // Shows how to access and manipulate cookies using PSR-7 Request
        // instances from outside the Request object itself.
        // Simulate a request coming in with several cookies.
        $request = (new FigCookieTestingRequest())
            ->withHeader(Cookies::COOKIE_HEADER, 'theme=light; sessionToken=RAPELCGRQ; hello=world');

        // Get our cookies from the request.
        $cookies = Cookies::fromRequest($request);

        // Ask for the encrypted session token.
        $encryptedSessionToken = $cookies->get('sessionToken');

        // Get the encrypted value from the cookie and decrypt it.
        $encryptedValue = $encryptedSessionToken->getValue();
        $decryptedValue = str_rot13($encryptedValue);

        // Create a new cookie with the decrypted value.
        $decryptedSessionToken = $encryptedSessionToken->withValue($decryptedValue);

        // Include our decrypted session token with the rest of our cookies.
        $cookies = $cookies->with($decryptedSessionToken);

        // Render our cookies, along with the newly decrypted session token, into a request.
        $request = $cookies->renderIntoCookieHeader($request);

        // From this point on, any request based on this one can get the plaintext version
        // of the session token.
        self::assertEquals(
            'theme=light; sessionToken=ENCRYPTED; hello=world',
            $request->getHeaderLine(Cookies::COOKIE_HEADER)
        );
    }

    /** @return string[][]|Cookie[][][] */
    public function provideCookieStringAndExpectedCookiesData(): array
    {
        return [
            [
                '',
                [],
            ],
            [
                'theme=light',
                [
                    Cookie::create('theme', 'light'),
                ],
            ],
            [
                'theme=light; sessionToken=abc123',
                [
                    Cookie::create('theme', 'light'),
                    Cookie::create('sessionToken', 'abc123'),
                ],
            ],
        ];
    }

    /** @return string[][]|Cookie[][] */
    public function provideGetsCookieByNameData(): array
    {
        return [
            ['theme=light', 'theme', Cookie::create('theme', 'light')],
            ['theme=', 'theme', Cookie::create('theme')],
            ['hello=world; theme=light; sessionToken=abc123', 'theme', Cookie::create('theme', 'light')],
            ['hello=world; theme=; sessionToken=abc123', 'theme', Cookie::create('theme')],
        ];
    }
}
