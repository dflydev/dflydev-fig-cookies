<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use RuntimeException;

class FigCookieTestingRequest implements RequestInterface
{
    use FigCookieTestingMessage;

    public function getRequestTarget(): string
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withRequestTarget($requestTarget)
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    public function getMethod(): string
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withMethod($method)
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    public function getUri(): UriInterface
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        throw new RuntimeException('This method has not been implemented.');
    }
}
