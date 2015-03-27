<?php

namespace Dflydev\FigCookies;

use Psr\Http\Message\RequestInterface;

class Cookies
{
    const COOKIE_HEADER = 'cookie';

    /**
     * @var Cookie[]
     */
    private $cookies = [];

    /**
     * @param Cookie[] $cookies
     */
    public function __construct(array $cookies = [])
    {
        foreach ($cookies as $cookie) {
            $this->cookies[$cookie->getName()] = $cookie;
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->cookies[$name]);
    }

    /**
     * @param $name
     * @return Cookie|null
     */
    public function get($name)
    {
        if (! $this->has($name)) {
            return null;
        }

        return $this->cookies[$name];
    }

    /**
     * @return Cookie[]
     */
    public function getAll()
    {
        return array_values($this->cookies);
    }

    /**
     * @param Cookie $cookie
     * @return Cookies
     */
    public function with(Cookie $cookie)
    {
        $clone = clone($this);

        $clone->cookies[$cookie->getName()] = $cookie;

        return $clone;
    }

    /**
     * @param $name
     * @return Cookies
     */
    public function without($name)
    {
        $clone = clone($this);

        if (! $clone->has($name)) {
            return $clone;
        }

        unset($clone->cookies[$name]);

        return $clone;
    }

    /**
     * @param RequestInterface $request
     * @return \Psr\Http\Message\MessageInterface|RequestInterface
     */
    public function renderIntoCookieHeader(RequestInterface $request)
    {
        $cookieString = implode('; ', $this->cookies);

        $request = $request->withHeader(static::COOKIE_HEADER, $cookieString);

        return $request;
    }

    public static function fromCookieString($string)
    {
        return new static(Cookie::listFromCookieString($string));
    }

    public static function fromRequest(RequestInterface $request)
    {
        $cookieString = $request->getHeader(static::COOKIE_HEADER);

        return static::fromCookieString($cookieString);
    }
}
