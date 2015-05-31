<?php

namespace Dflydev\FigCookies;

use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class FigCookies
{
    /**
     * @param RequestInterface $request
     * @param Cookie $cookie
     *
     * @return RequestInterface
     */
    public static function setRequestCookie(RequestInterface $request, Cookie $cookie)
    {
        return Cookies::fromRequest($request)
            ->with($cookie)
            ->renderIntoCookieHeader($request)
        ;
    }

    /**
     * @param RequestInterface $request
     * @param string $name
     * @param string|null $value
     *
     * @return RequestInterface
     */
    public static function setRequestCookieFromStrings(RequestInterface $request, $name, $value = null)
    {
        return Cookies::fromRequest($request)
            ->with(Cookie::create($name, $value))
            ->renderIntoCookieHeader($request)
        ;
    }

    /**
     * @param RequestInterface $request
     * @param string $name
     * @param callable $modify
     *
     * @return RequestInterface
     */
    public static function modifyRequestCookie(RequestInterface $request, $name, $modify)
    {
        if (! is_callable($modify)) {
            throw new InvalidArgumentException('$modify must be callable.');
        }

        $cookies = Cookies::fromRequest($request);
        $cookie = $modify($cookies->has($name)
            ? $cookies->get($name)
            : Cookie::create($name)
        );

        return $cookies
            ->with($cookie)
            ->renderIntoCookieHeader($request)
        ;
    }

    /**
     * @param RequestInterface $request
     * @param string $name
     *
     * @return RequestInterface
     */
    public static function removeRequestCookie(RequestInterface $request, $name)
    {
        return Cookies::fromRequest($request)
            ->without($name)
            ->renderIntoCookieHeader($request)
        ;
    }

    /**
     * @param ResponseInterface $response
     * @param SetCookie $setCookie
     *
     * @return ResponseInterface
     */
    public static function setResponseSetCookie(ResponseInterface $response, SetCookie $setCookie)
    {
        return SetCookies::fromResponse($response)
            ->with($setCookie)
            ->renderIntoSetCookieHeader($response)
        ;
    }

    /**
     * @param ResponseInterface $response
     * @param string $name
     * @param callable $modify
     *
     * @return ResponseInterface
     */
    public static function modifyResponseSetCookie(ResponseInterface $response, $name, $modify)
    {
        if (! is_callable($modify)) {
            throw new InvalidArgumentException('$modify must be callable.');
        }

        $setCookies = SetCookies::fromResponse($response);
        $setCookie = $modify($setCookies->has($name)
            ? $setCookies->get($name)
            : SetCookie::create($name)
        );

        return $setCookies
            ->with($setCookie)
            ->renderIntoSetCookieHeader($response)
        ;
    }

    /**
     * @param ResponseInterface $response
     * @param string $name
     *
     * @return ResponseInterface
     */
    public static function removeResponseSetCookie(ResponseInterface $response, $name)
    {
        return SetCookies::fromResponse($response)
            ->without($name)
            ->renderIntoSetCookieHeader($response)
        ;
    }
}
