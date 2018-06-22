<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use Psr\Http\Message\ResponseInterface;

class FigCookieTestingResponse implements ResponseInterface
{
    use FigCookieTestingMessage;

    public function getStatusCode() : void
    {
        throw new \RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withStatus($code, $reasonPhrase = '') : void
    {
        throw new \RuntimeException('This method has not been implemented.');
    }

    public function getReasonPhrase() : void
    {
        throw new \RuntimeException('This method has not been implemented.');
    }
}
