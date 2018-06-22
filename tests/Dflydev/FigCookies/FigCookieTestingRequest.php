<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class FigCookieTestingRequest implements RequestInterface
{
    use FigCookieTestingMessage;

    public function getRequestTarget() : void
    {
        throw new \RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withRequestTarget($requestTarget) : void
    {
        throw new \RuntimeException('This method has not been implemented.');
    }

    public function getMethod() : void
    {
        throw new \RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withMethod($method) : void
    {
        throw new \RuntimeException('This method has not been implemented.');
    }

    public function getUri() : void
    {
        throw new \RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withUri(UriInterface $uri, $preserveHost = false) : void
    {
        throw new \RuntimeException('This method has not been implemented.');
    }
}
