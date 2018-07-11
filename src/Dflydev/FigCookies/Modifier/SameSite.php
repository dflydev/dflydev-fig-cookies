<?php

declare(strict_types=1);

namespace Dflydev\FigCookies\Modifier;

use function sprintf;
use function strtolower;

final class SameSite
{
    /** @var bool */
    private $strict;

    private function __construct(bool $strict)
    {
        $this->strict = $strict;
    }

    public static function strict() : self
    {
        return new self(true);
    }

    public static function lax() : self
    {
        return new self(false);
    }

    /**
     * @throws \InvalidArgumentException If the given SameSite string is neither strict nor lax.
     */
    public static function fromString(string $sameSite) : self
    {
        $lowerCaseSite = strtolower($sameSite);

        if ($lowerCaseSite === 'strict') {
            return self::strict();
        }

        if ($lowerCaseSite === 'lax') {
            return self::lax();
        }

        throw new \InvalidArgumentException(sprintf(
            'Expected modifier value to be either "strict" or "lax", "%s" given',
            $sameSite
        ));
    }

    public function asString() : string
    {
        return 'SameSite=' . ($this->strict ? 'Strict' : 'Lax');
    }
}
