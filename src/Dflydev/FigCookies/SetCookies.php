<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use Psr\Http\Message\ResponseInterface;
use function array_map;
use function array_values;

class SetCookies
{
    /**
     * The name of the Set-Cookie header.
     */
    public const SET_COOKIE_HEADER = 'Set-Cookie';

    /** @var SetCookie[] */
    private $setCookies = [];

    /** @param SetCookie[] $setCookies */
    public function __construct(array $setCookies = [])
    {
        foreach ($setCookies as $setCookie) {
            $this->setCookies[$setCookie->getName()] = $setCookie;
        }
    }

    public function has(string $name) : bool
    {
        return isset($this->setCookies[$name]);
    }

    public function get(string $name) : ?SetCookie
    {
        if (! $this->has($name)) {
            return null;
        }

        return $this->setCookies[$name];
    }

    /** @return SetCookie[] */
    public function getAll() : array
    {
        return array_values($this->setCookies);
    }

    public function with(SetCookie $setCookie) : SetCookies
    {
        $clone = clone($this);

        $clone->setCookies[$setCookie->getName()] = $setCookie;

        return $clone;
    }

    public function without(string $name) : SetCookies
    {
        $clone = clone($this);

        if (! $clone->has($name)) {
            return $clone;
        }

        unset($clone->setCookies[$name]);

        return $clone;
    }

    /**
     * Render SetCookies into a Response.
     *
     */
    public function renderIntoSetCookieHeader(ResponseInterface $response) : ResponseInterface
    {
        $response = $response->withoutHeader(static::SET_COOKIE_HEADER);
        foreach ($this->setCookies as $setCookie) {
            $response = $response->withAddedHeader(static::SET_COOKIE_HEADER, (string) $setCookie);
        }

        return $response;
    }

    /**
     * Create SetCookies from a collection of SetCookie header value strings.
     *
     * @param string[] $setCookieStrings
     * @return static
     */
    public static function fromSetCookieStrings(array $setCookieStrings) : self
    {
        return new static(array_map(function (string $setCookieString) : SetCookie {
            return SetCookie::fromSetCookieString($setCookieString);
        }, $setCookieStrings));
    }

    /**
     * Create SetCookies from a Response.
     *
     */
    public static function fromResponse(ResponseInterface $response) : SetCookies
    {
        return new static(array_map(function (string $setCookieString) : SetCookie {
            return SetCookie::fromSetCookieString($setCookieString);
        }, $response->getHeader(static::SET_COOKIE_HEADER)));
    }
}
