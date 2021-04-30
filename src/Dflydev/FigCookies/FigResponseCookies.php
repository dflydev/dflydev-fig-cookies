<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

use function is_callable;

class FigResponseCookies
{
    public static function get(ResponseInterface $response, string $name, ?string $value = null): SetCookie
    {
        $setCookies = SetCookies::fromResponse($response);
        $cookie     = $setCookies->get($name);

        if ($cookie) {
            return $cookie;
        }

        return SetCookie::create($name, $value);
    }

    public static function set(ResponseInterface $response, SetCookie $setCookie): ResponseInterface
    {
        return SetCookies::fromResponse($response)
            ->with($setCookie)
            ->renderIntoSetCookieHeader($response);
    }

    /**
     * @deprecated Do not use this method. Will be removed in v4.0.
     *
     * If you want to remove a cookie, create it normally and call ->expire()
     * on the SetCookie object.
     */
    public static function expire(ResponseInterface $response, string $cookieName): ResponseInterface
    {
        return static::set($response, SetCookie::createExpired($cookieName));
    }

    public static function modify(ResponseInterface $response, string $name, callable $modify): ResponseInterface
    {
        if (! is_callable($modify)) {
            throw new InvalidArgumentException('$modify must be callable.');
        }

        $setCookies = SetCookies::fromResponse($response);
        $setCookie  = $modify($setCookies->has($name)
            ? $setCookies->get($name)
            : SetCookie::create($name));

        return $setCookies
            ->with($setCookie)
            ->renderIntoSetCookieHeader($response);
    }

    public static function remove(ResponseInterface $response, string $name): ResponseInterface
    {
        return SetCookies::fromResponse($response)
            ->without($name)
            ->renderIntoSetCookieHeader($response);
    }
}
