<?php

namespace Dflydev\FigCookies;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamableInterface;
use Psr\Http\Message\UriInterface;
use string;

class FigCookieTestingRequest implements RequestInterface
{
    private $headers = [];
    public function getProtocolVersion()
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function withProtocolVersion($version)
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function hasHeader($name)
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function withHeader($name, $value)
    {
        $clone = clone($this);

        $clone->headers[$name] = [$value];

        return $clone;
    }

    public function withAddedHeader($name, $value)
    {
        $clone = clone($this);

        if (! isset($clone->headers[$name])) {
            $clone->headers[$name] = [];
        }

        $clone->headers[$name][] = $value;

        return $clone;
    }

    public function withoutHeader($name)
    {
        $clone = clone($this);

        if (isset($clone->headers[$name])) {
            unset($clone->headers[$name]);
        }

        return $clone;
    }

    public function getBody()
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function withBody(StreamableInterface $body)
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function getHeaders()
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function getHeader($name)
    {
        if (! isset($this->headers[$name])) {
            return '';
        }

        return implode(', ', $this->headers[$name]);
    }

    public function getHeaderLines($name)
    {
        if (! isset($this->headers[$name])) {
            return [];
        }

        return $this->headers[$name];
    }

    public function getRequestTarget()
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function withRequestTarget($requestTarget)
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function getMethod()
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function withMethod($method)
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function getUri()
    {
        throw new \RuntimeException("This method has not been implemented.");
    }

    public function withUri(UriInterface $uri)
    {
        throw new \RuntimeException("This method has not been implemented.");
    }
}
