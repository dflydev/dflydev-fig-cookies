<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use DateTime;
use Dflydev\FigCookies\Modifier\SameSite;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use function time;

class SetCookieTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideParsesFromSetCookieStringData
     */
    public function it_parses_from_set_cookie_string(string $cookieString, SetCookie $expectedSetCookie): void
    {
        $setCookie = SetCookie::fromSetCookieString($cookieString);

        self::assertEquals($expectedSetCookie, $setCookie);
        self::assertEquals($cookieString, (string) $setCookie);
    }

    /** @return string[][]|SetCookie[][] */
    public function provideParsesFromSetCookieStringData(): array
    {
        return [
            [
                'someCookie=',
                SetCookie::create('someCookie'),
            ],
            [
                'someCookie=someValue',
                SetCookie::create('someCookie')
                    ->withValue('someValue'),
            ],
            [
                'LSID=DQAAAK%2FEaem_vYg; Path=/accounts; Expires=Wed, 13 Jan 2021 22:23:01 GMT; Secure; HttpOnly',
                SetCookie::create('LSID')
                    ->withValue('DQAAAK/Eaem_vYg')
                    ->withPath('/accounts')
                    ->withExpires('Wed, 13 Jan 2021 22:23:01 GMT')
                    ->withSecure(true)
                    ->withHttpOnly(true),
            ],
            [
                'HSID=AYQEVn%2F.DKrdst; Domain=.foo.com; Path=/; Expires=Wed, 13 Jan 2021 22:23:01 GMT; HttpOnly',
                SetCookie::create('HSID')
                    ->withValue('AYQEVn/.DKrdst')
                    ->withDomain('.foo.com')
                    ->withPath('/')
                    ->withExpires('Wed, 13 Jan 2021 22:23:01 GMT')
                    ->withHttpOnly(true),
            ],
            [
                'SSID=Ap4P%2F.GTEq; Domain=foo.com; Path=/; Expires=Wed, 13 Jan 2021 22:23:01 GMT; Secure; HttpOnly',
                SetCookie::create('SSID')
                    ->withValue('Ap4P/.GTEq')
                    ->withDomain('foo.com')
                    ->withPath('/')
                    ->withExpires('Wed, 13 Jan 2021 22:23:01 GMT')
                    ->withSecure(true)
                    ->withHttpOnly(true),
            ],
            [
                'lu=Rg3vHJZnehYLjVg7qi3bZjzg; Domain=.example.com; Path=/; Expires=Tue, 15 Jan 2013 21:47:38 GMT; HttpOnly',
                SetCookie::create('lu')
                    ->withValue('Rg3vHJZnehYLjVg7qi3bZjzg')
                    ->withExpires('Tue, 15-Jan-2013 21:47:38 GMT')
                    ->withPath('/')
                    ->withDomain('.example.com')
                    ->withHttpOnly(true),
            ],
            [
                'lu=Rg3vHJZnehYLjVg7qi3bZjzg; Domain=.example.com; Path=/; Max-Age=500; Secure; HttpOnly',
                SetCookie::create('lu')
                    ->withValue('Rg3vHJZnehYLjVg7qi3bZjzg')
                    ->withMaxAge(500)
                    ->withPath('/')
                    ->withDomain('.example.com')
                    ->withSecure(true)
                    ->withHttpOnly(true),
            ],
            [
                'lu=Rg3vHJZnehYLjVg7qi3bZjzg; Domain=.example.com; Path=/; Expires=Tue, 15 Jan 2013 21:47:38 GMT; Max-Age=500; Secure; HttpOnly',
                SetCookie::create('lu')
                    ->withValue('Rg3vHJZnehYLjVg7qi3bZjzg')
                    ->withExpires('Tue, 15-Jan-2013 21:47:38 GMT')
                    ->withMaxAge(500)
                    ->withPath('/')
                    ->withDomain('.example.com')
                    ->withSecure(true)
                    ->withHttpOnly(true),
            ],
            [
                'lu=Rg3vHJZnehYLjVg7qi3bZjzg; Domain=.example.com; Path=/; Expires=Tue, 15 Jan 2013 21:47:38 GMT; Max-Age=500; Secure; HttpOnly',
                SetCookie::create('lu')
                    ->withValue('Rg3vHJZnehYLjVg7qi3bZjzg')
                    ->withExpires(1358286458)
                    ->withMaxAge(500)
                    ->withPath('/')
                    ->withDomain('.example.com')
                    ->withSecure(true)
                    ->withHttpOnly(true),
            ],
            [
                'lu=Rg3vHJZnehYLjVg7qi3bZjzg; Domain=.example.com; Path=/; Expires=Tue, 15 Jan 2013 21:47:38 GMT; Max-Age=500; Secure; HttpOnly',
                SetCookie::create('lu')
                         ->withValue('Rg3vHJZnehYLjVg7qi3bZjzg')
                         ->withExpires(new DateTime('Tue, 15-Jan-2013 21:47:38 GMT'))
                         ->withMaxAge(500)
                         ->withPath('/')
                         ->withDomain('.example.com')
                         ->withSecure(true)
                         ->withHttpOnly(true),
            ],
            [
                'lu=Rg3vHJZnehYLjVg7qi3bZjzg; Domain=.example.com; Path=/; Expires=Tue, 15 Jan 2013 21:47:38 GMT; Max-Age=500; Secure; HttpOnly; SameSite=Strict',
                SetCookie::create('lu')
                         ->withValue('Rg3vHJZnehYLjVg7qi3bZjzg')
                         ->withExpires(new DateTime('Tue, 15-Jan-2013 21:47:38 GMT'))
                         ->withMaxAge(500)
                         ->withPath('/')
                         ->withDomain('.example.com')
                         ->withSecure(true)
                         ->withHttpOnly(true)
                         ->withSameSite(SameSite::strict()),
            ],
            [
                'lu=Rg3vHJZnehYLjVg7qi3bZjzg; Domain=.example.com; Path=/; Expires=Tue, 15 Jan 2013 21:47:38 GMT; Max-Age=500; Secure; HttpOnly; SameSite=Lax',
                SetCookie::create('lu')
                         ->withValue('Rg3vHJZnehYLjVg7qi3bZjzg')
                         ->withExpires(new DateTime('Tue, 15-Jan-2013 21:47:38 GMT'))
                         ->withMaxAge(500)
                         ->withPath('/')
                         ->withDomain('.example.com')
                         ->withSecure(true)
                         ->withHttpOnly(true)
                         ->withSameSite(SameSite::lax()),
            ],
        ];
    }

    /**
     * @test
     */
    public function it_expires_cookies(): void
    {
        $setCookie = SetCookie::create('HSID')
            ->withValue('AYQEVn/.DKrdst')
            ->withDomain('.foo.com')
            ->withPath('/')
            ->withHttpOnly(true)
            ->expire();

        self::assertLessThan(time(), $setCookie->getExpires());
    }

    /**
     * @test
     */
    public function it_creates_long_living_cookies(): void
    {
        $setCookie = SetCookie::createRememberedForever('remember_forever');

        $fourYearsFromNow = (new DateTime('+4 years'))->getTimestamp();
        self::assertGreaterThan($fourYearsFromNow, $setCookie->getExpires());
    }

    /** @test */
    public function SameSite_modifier_can_be_added_and_removed(): void
    {
        $setCookie = SetCookie::create('foo', 'bar');

        self::assertNull($setCookie->getSameSite());
        self::assertSame('foo=bar', $setCookie->__toString());

        $setCookie = $setCookie->withSameSite(SameSite::strict());

        self::assertEquals(SameSite::strict(), $setCookie->getSameSite());
        self::assertSame('foo=bar; SameSite=Strict', $setCookie->__toString());

        $setCookie = $setCookie->withoutSameSite();
        self::assertNull($setCookie->getSameSite());
        self::assertSame('foo=bar', $setCookie->__toString());
    }

    /** @test */
    public function invalid_expires_format_will_be_rejected(): void
    {
        $setCookie = SetCookie::create('foo', 'bar');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid expires "potato" provided');

        $setCookie->withExpires('potato');
    }

    /** @test */
    public function empty_cookie_is_rejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The provided cookie string "" must have at least one attribute');

        SetCookie::fromSetCookieString('');
    }

    /**
     * @param array<mixed> $config
     *
     * @test
     * @dataProvider withConfigData
     */
    public function it_creates_withConfig(array $config, SetCookie $expected): void
    {
        $setCookie = SetCookie::create($config['name'])->withConfig($config);
        self::assertEquals($expected, $setCookie);
    }

    /** @return array<mixed> */
    public function withConfigData(): array
    {
        return [
            [
                [
                    'name' => 'BZXLFIX',
                    'value' => '6349705',
                    'maxAge' => 60 * 5,
                    'path' => '/',
                    'domain' => '',
                    'secure' => true,
                    'httpOnly' => true,
                    'sameSite' => 'strict',
                ],
                SetCookie::create('BZXLFIX', '6349705')
                    ->withMaxAge(60 * 5)
                    ->withPath('/')
                    ->withDomain('')
                    ->withSecure(true)
                    ->withHttpOnly(true)
                    ->withSameSite(SameSite::fromString('Strict')),
            ],
        ];
    }

    /**
     * @param array<mixed> $config
     *
     * @return void     *
     *
     * @test
     * @dataProvider CreateFromConfigData
     */
    public function it_creates_fromConfig(array $config, SetCookie $expected): void
    {
        $setCookie = SetCookie::fromConfig($config);
        self::assertEquals($expected, $setCookie);
    }

    /**
     * @param array<mixed> $config
     *
     * @return void     *
     *
     * @test
     * @dataProvider CreateFromConfigData
     */
    public function throws_invalidArgument_without_name(array $config): void
    {
        unset($config['name']);
        $this->expectException(InvalidArgumentException::class);
        $setCookie = SetCookie::fromConfig($config);
    }

    /** @return array<mixed> */
    public function CreateFromConfigData(): array
    {
        return [
            [
                [
                    'name' => 'LISA_',
                    'value' => '6349705',
                    'path' => '/',
                    'domain' => 'example.com',
                    'secure' => true,
                    'httpOnly' => true,
                    'expires' => 'Tue, 15-Jan-2013 21:47:38 GMT',
                    'sameSite' => 'Lax',
                ],
                SetCookie::create('LISA_', '6349705')
                    ->withExpires(1358286458)
                    ->withSameSite(SameSite::fromString('lax'))
                    ->withPath('/')
                    ->withDomain('example.com')
                    ->withSecure(true)
                    ->withHttpOnly(true),
            ],
            [
                [
                    'name' => 'LISA_',
                    'value' => '6349705',
                    'expires' => 1358286458,
                    'path' => '/',
                    'domain' => 'example.com',
                    'secure' => true,
                    'httpOnly' => true,
                    'sameSite' => 'NONE',
                ],
                SetCookie::create('LISA_', '6349705')
                    ->withPath('/')
                    ->withDomain('example.com')
                    ->withSecure(true)
                    ->withHttpOnly(true)
                    ->withExpires('Tue, 15-Jan-2013 21:47:38 GMT')
                    ->withSameSite(SameSite::fromString('none')),
            ],
        ];
    }
}
