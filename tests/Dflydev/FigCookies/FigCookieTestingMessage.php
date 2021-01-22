<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use Psr\Http\Message\StreamInterface;
use RuntimeException;

use function implode;

trait FigCookieTestingMessage
{
    /** @var array<string, string[]> */
    private $headers = [];

    /** {@inheritDoc} */
    public function getProtocolVersion(): string
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withProtocolVersion($version)
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function hasHeader($name): bool
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withHeader($name, $value)
    {
        $clone = clone $this;

        $clone->headers[$name] = [$value];

        return $clone;
    }

    /** {@inheritDoc} */
    public function withAddedHeader($name, $value)
    {
        $clone = clone $this;

        if (! isset($clone->headers[$name])) {
            $clone->headers[$name] = [];
        }

        $clone->headers[$name][] = $value;

        return $clone;
    }

    /** {@inheritDoc} */
    public function withoutHeader($name)
    {
        $clone = clone $this;

        if (isset($clone->headers[$name])) {
            unset($clone->headers[$name]);
        }

        return $clone;
    }

    /** {@inheritDoc} */
    public function getBody(): StreamInterface
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withBody(StreamInterface $body): StreamInterface
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function getHeaders(): array
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function getHeader($name)
    {
        if (! isset($this->headers[$name])) {
            return [];
        }

        return $this->headers[$name];
    }

    /** {@inheritDoc} */
    public function getHeaderLine($name)
    {
        return implode(',', $this->headers[$name]);
    }

    /** {@inheritDoc} */
    public function getHeaderLines($name)
    {
        if (! isset($this->headers[$name])) {
            return [];
        }

        return $this->headers[$name];
    }
}
