<?php

namespace Dflydev\FigCookies\Modifier;

final class SameSite
{
    /** @var bool */
    private $strict;

    /** @param bool $strict */
    private function __construct($strict)
    {
        $this->strict = $strict;
    }

    /** @return self */
    public static function strict()
    {
        return new self(true);
    }

    /** @return self */
    public static function lax()
    {
        return new self(false);
    }

    /**
     * @param string $sameSite
     *
     * @return self
     *
     * @throws \InvalidArgumentException if the given SameSite string is neither strict nor lax
     */
    public static function fromString($sameSite)
    {
        $lowerCaseSite = \strtolower($sameSite);

        if ($lowerCaseSite === 'strict') {
            return self::strict();
        }

        if ($lowerCaseSite === 'lax') {
            return self::lax();
        }

        throw new \InvalidArgumentException(\sprintf(
            'Expected modifier value to be either "strict" or "lax", "%s" given',
            $sameSite
        ));
    }

    /** @return string */
    public function asString()
    {
        return 'SameSite=' . ($this->strict ? 'Strict' : 'Lax');
    }
}
