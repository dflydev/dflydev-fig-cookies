<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use Psr\Http\Message\RequestInterface;
use function array_values;
use function implode;

class Cookies
{
    /**
     * The name of the Cookie header.
     */
    public const COOKIE_HEADER = 'Cookie';

    /** @var Cookie[] */
    private $cookies = [];

    /** @param Cookie[] $cookies */
    public function __construct(array $cookies = [])
    {
        foreach ($cookies as $cookie) {
            $this->cookies[$cookie->getName()] = $cookie;
        }
    }

    public function has(string $name) : bool
    {
        return isset($this->cookies[$name]);
    }

    public function get(string $name) : ?Cookie
    {
        if (! $this->has($name)) {
            return null;
        }

        return $this->cookies[$name];
    }

    /** @return Cookie[] */
    public function getAll() : array
    {
        return array_values($this->cookies);
    }

    public function with(Cookie $cookie) : Cookies
    {
        $clone = clone($this);

        $clone->cookies[$cookie->getName()] = $cookie;

        return $clone;
    }

    public function without(string $name) : Cookies
    {
        $clone = clone($this);

        if (! $clone->has($name)) {
            return $clone;
        }

        unset($clone->cookies[$name]);

        return $clone;
    }

    /**
     * Render Cookies into a Request.
     */
    public function renderIntoCookieHeader(RequestInterface $request) : RequestInterface
    {
        $cookieString = implode('; ', $this->cookies);

        $request = $request->withHeader(static::COOKIE_HEADER, $cookieString);

        return $request;
    }

    /**
     * Create Cookies from a Cookie header value string.
     *
     * @return static
     */
    public static function fromCookieString(string $string) : self
    {
        return new static(Cookie::listFromCookieString($string));
    }

    public static function fromRequest(RequestInterface $request) : Cookies
    {
        $cookieString = $request->getHeaderLine(static::COOKIE_HEADER);

        return static::fromCookieString($cookieString);
    }
}
