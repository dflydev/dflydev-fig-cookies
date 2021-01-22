<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

use function is_callable;

class FigRequestCookies
{
    public static function get(RequestInterface $request, string $name, ?string $value = null): Cookie
    {
        $cookies = Cookies::fromRequest($request);
        $cookie  = $cookies->get($name);

        if ($cookie) {
            return $cookie;
        }

        return Cookie::create($name, $value);
    }

    public static function set(RequestInterface $request, Cookie $cookie): RequestInterface
    {
        return Cookies::fromRequest($request)
            ->with($cookie)
            ->renderIntoCookieHeader($request);
    }

    public static function modify(RequestInterface $request, string $name, callable $modify): RequestInterface
    {
        if (! is_callable($modify)) {
            throw new InvalidArgumentException('$modify must be callable.');
        }

        $cookies = Cookies::fromRequest($request);
        $cookie  = $modify($cookies->has($name)
            ? $cookies->get($name)
            : Cookie::create($name));

        return $cookies
            ->with($cookie)
            ->renderIntoCookieHeader($request);
    }

    public static function remove(RequestInterface $request, string $name): RequestInterface
    {
        return Cookies::fromRequest($request)
            ->without($name)
            ->renderIntoCookieHeader($request);
    }
}
