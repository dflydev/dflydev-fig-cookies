<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class FigCookieTestingResponse implements ResponseInterface
{
    use FigCookieTestingMessage;

    public function getStatusCode(): int
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    /** {@inheritDoc} */
    public function withStatus($code, $reasonPhrase = '')
    {
        throw new RuntimeException('This method has not been implemented.');
    }

    public function getReasonPhrase(): string
    {
        throw new RuntimeException('This method has not been implemented.');
    }
}
