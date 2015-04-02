<?php

namespace Dflydev\FigCookies;

class Cookie
{
    private $name;
    private $value;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function withValue($value = null)
    {
        if ($this->hasValueEqualTo($value)) {
            return $this;
        }

        return $this->cloneWithValue($value);
    }

    public function __toString()
    {
        return urlencode($this->name).'='.urlencode($this->value);
    }

    public static function create($name)
    {
        return new static($name);
    }

    public static function listFromCookieString($string)
    {
        $cookies = StringUtil::splitOnAttributeDelimiter($string);

        return array_map(function ($cookiePair) {
            return static::oneFromCookieString($cookiePair);
        }, $cookies);
    }

    public static function oneFromCookieString($string)
    {
        list ($cookieName, $cookieValue) = StringUtil::splitCookiePair($string);

        /** @var Cookie $cookie */
        $cookie = new static($cookieName);

        if (! is_null($cookieValue)) {
            $cookie = $cookie->withValue($cookieValue);
        }

        return $cookie;
    }

    private function hasValueEqualTo($value = null)
    {
        return $value === $this->value;
    }

    private function cloneWithValue($value = null)
    {
        $clone = clone($this);

        $clone->value = $value;

        return $clone;
    }
}
