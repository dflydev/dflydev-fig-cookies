<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

use function str_rot13;

class SetCookiesTest extends TestCase
{
    public const INTERFACE_PSR_HTTP_MESSAGE_RESPONSE = ResponseInterface::class;

    /**
     * @param string[]    $setCookieStrings
     * @param SetCookie[] $expectedSetCookies
     *
     * @test
     * @dataProvider provideSetCookieStringsAndExpectedSetCookiesData
     */
    public function it_creates_from_response(array $setCookieStrings, array $expectedSetCookies): void
    {
        /** @var ResponseInterface|MockObject $response */
        $response = $this->createMock(self::INTERFACE_PSR_HTTP_MESSAGE_RESPONSE);
        $response->expects(self::once())->method('getHeader')->with(SetCookies::SET_COOKIE_HEADER)->willReturn($setCookieStrings);

        $setCookies = SetCookies::fromResponse($response);

        self::assertEquals($expectedSetCookies, $setCookies->getAll());
    }

    /**
     * @param string[]    $setCookieStrings
     * @param SetCookie[] $expectedSetCookies
     *
     * @test
     * @dataProvider provideSetCookieStringsAndExpectedSetCookiesData
     */
    public function it_creates_from_set_cookie_strings(array $setCookieStrings, array $expectedSetCookies): void
    {
        $setCookies = SetCookies::fromSetCookieStrings($setCookieStrings);

        self::assertEquals($expectedSetCookies, $setCookies->getAll());
    }

    /**
     * @param string[]    $setCookieStrings
     * @param SetCookie[] $expectedSetCookies
     *
     * @test
     * @dataProvider provideSetCookieStringsAndExpectedSetCookiesData
     */
    public function it_knows_which_set_cookies_are_available(array $setCookieStrings, array $expectedSetCookies): void
    {
        $setCookies = SetCookies::fromSetCookieStrings($setCookieStrings);

        foreach ($expectedSetCookies as $expectedSetCookie) {
            self::assertTrue($setCookies->has($expectedSetCookie->getName()));
        }

        self::assertFalse($setCookies->has('i know this cookie does not exist'));
    }

    /**
     * @param string[] $setCookieStrings
     *
     * @test
     * @dataProvider provideGetsSetCookieByNameData
     */
    public function it_gets_set_cookie_by_name(array $setCookieStrings, string $setCookieName, ?SetCookie $expectedSetCookie = null): void
    {
        $setCookies = SetCookies::fromSetCookieStrings($setCookieStrings);

        self::assertEquals($expectedSetCookie, $setCookies->get($setCookieName));
    }

    /**
     * @test
     */
    public function it_renders_added_and_removed_set_cookies_header(): void
    {
        $setCookies = SetCookies::fromSetCookieStrings(['theme=light', 'sessionToken=abc123', 'hello=world'])
            ->with(SetCookie::create('theme', 'blue'))
            ->without('sessionToken')
            ->with(SetCookie::create('who', 'me'));

        $originalResponse = new FigCookieTestingResponse();
        $response         = $setCookies->renderIntoSetCookieHeader($originalResponse);

        self::assertNotEquals($response, $originalResponse);

        self::assertEquals(
            ['theme=blue', 'hello=world', 'who=me'],
            $response->getHeader(SetCookies::SET_COOKIE_HEADER)
        );
    }

    /**
     * @test
     */
    public function it_gets_and_updates_set_cookie_value_on_request(): void
    {
        // Example of naive cookie encryption middleware.
        //
        // Shows how to access and manipulate cookies using PSR-7 Response
        // instances from outside the Response object itself.
        // Simulate a response coming in with several cookies.
        $response = (new FigCookieTestingResponse())
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, 'theme=light')
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, 'sessionToken=ENCRYPTED')
            ->withAddedHeader(SetCookies::SET_COOKIE_HEADER, 'hello=world');

        // Get our set cookies from the response.
        $setCookies = SetCookies::fromResponse($response);

        // Ask for the encrypted session token.
        $decryptedSessionToken = $setCookies->get('sessionToken');

        // Get the encrypted value from the cookie and decrypt it.
        $decryptedValue = $decryptedSessionToken->getValue();
        $encryptedValue = str_rot13($decryptedValue);

        // Create a new set cookie with the encrypted value.
        $encryptedSessionToken = $decryptedSessionToken->withValue($encryptedValue);

        // Include our encrypted session token with the rest of our cookies.
        $setCookies = $setCookies->with($encryptedSessionToken);

        // Render our cookies, along with the newly decrypted session token, into a response.
        $response = $setCookies->renderIntoSetCookieHeader($response);

        // From this point on, any response based on this one can get the encrypted version
        // of the session token.
        self::assertEquals(
            ['theme=light', 'sessionToken=RAPELCGRQ', 'hello=world'],
            $response->getHeader(SetCookies::SET_COOKIE_HEADER)
        );
    }

    /** @return string[][][]|SetCookie[][][] */
    public function provideSetCookieStringsAndExpectedSetCookiesData(): array
    {
        return [
            [
                [],
                [],
            ],
            [
                ['someCookie='],
                [
                    SetCookie::create('someCookie'),
                ],
            ],
            [
                [
                    'someCookie=someValue',
                    'LSID=DQAAAK%2FEaem_vYg; Path=/accounts; Expires=Wed, 13 Jan 2021 22:23:01 GMT; Secure; HttpOnly',
                ],
                [
                    SetCookie::create('someCookie', 'someValue'),
                    SetCookie::create('LSID')
                        ->withValue('DQAAAK/Eaem_vYg')
                        ->withPath('/accounts')
                        ->withExpires('Wed, 13 Jan 2021 22:23:01 GMT')
                        ->withSecure(true)
                        ->withHttpOnly(true),
                ],
            ],
            [
                [
                    'a=AAA',
                    'b=BBB',
                    'c=CCC',
                ],
                [
                    SetCookie::create('a', 'AAA'),
                    SetCookie::create('b', 'BBB'),
                    SetCookie::create('c', 'CCC'),
                ],
            ],
        ];
    }

    /** @return string[][]|string[][][]|SetCookie[][]|null[][] */
    public function provideGetsSetCookieByNameData(): array
    {
        return [
            [
                [
                    'a=AAA',
                    'b=BBB',
                    'c=CCC',
                ],
                'b',
                SetCookie::create('b', 'BBB'),
            ],
            [
                [
                    'a=AAA',
                    'b=BBB',
                    'c=CCC',
                    'LSID=DQAAAK%2FEaem_vYg; Path=/accounts; Expires=Wed, 13 Jan 2021 22:23:01 GMT; Secure; HttpOnly',
                ],
                'LSID',
                SetCookie::create('LSID')
                    ->withValue('DQAAAK/Eaem_vYg')
                    ->withPath('/accounts')
                    ->withExpires('Wed, 13 Jan 2021 22:23:01 GMT')
                    ->withSecure(true)
                    ->withHttpOnly(true),
            ],
            [
                [
                    'a=AAA',
                    'b=BBB',
                    'c=CCC',
                ],
                'LSID',
                null,
            ],
        ];
    }
}
