<?php

declare(strict_types=1);

namespace Dflydev\FigCookies;

use function array_filter;
use function array_map;
use function count;
use function explode;
use function preg_split;
use function urldecode;

class StringUtil
{
    /** @return string[] */
    public static function splitOnAttributeDelimiter(string $string) : array
    {
        return array_filter(preg_split('@\s*[;]\s*@', $string));
    }

    /** @return string[] */
    public static function splitCookiePair(string $string) : array
    {
        $pairParts = explode('=', $string, 2);

        if (count($pairParts) === 1) {
            $pairParts[1] = '';
        }

        return array_map(function ($part) {
            return urldecode($part);
        }, $pairParts);
    }
}
