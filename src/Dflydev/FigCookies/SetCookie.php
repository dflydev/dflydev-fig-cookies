<?php

namespace Dflydev\FigCookies;

class SetCookie
{
    private $name;
    private $value;
    private $expires = 0;
    private $maxAge = 0;
    private $path;
    private $domain;
    private $secure = false;
    private $httpOnly = false;

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

    public function getExpires()
    {
        return $this->expires;
    }

    public function getMaxAge()
    {
        return $this->maxAge;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getSecure()
    {
        return $this->secure;
    }

    public function getHttpOnly()
    {
        return $this->httpOnly;
    }

    public function withValue($value = null)
    {
        $clone = clone($this);

        $clone->value = $value;

        return $clone;
    }

    public function withExpires($expires)
    {
        $clone = clone($this);

        $clone->expires = is_numeric($expires) ? $expires : strtotime($expires);

        return $clone;
    }

    public function withMaxAge($maxAge)
    {
        $clone = clone($this);

        $clone->maxAge = $maxAge;

        return $clone;
    }

    public function withPath($path = null)
    {
        $clone = clone($this);

        $clone->path = $path;

        return $clone;
    }

    public function withDomain($domain = null)
    {
        $clone = clone($this);

        $clone->domain = $domain;

        return $clone;
    }

    public function withSecure($secure = null)
    {
        $clone = clone($this);

        $clone->secure = $secure;

        return $clone;
    }

    public function withHttpOnly($httpOnly = null)
    {
        $clone = clone($this);

        $clone->httpOnly = $httpOnly;

        return $clone;
    }

    public function __toString()
    {
        $cookieStringParts = [
            urlencode($this->name).'='.urlencode($this->value),
        ];

        if ($this->domain) {
            $cookieStringParts[] = sprintf("Domain=%s", $this->domain);
        }

        if ($this->path) {
            $cookieStringParts[] = sprintf("Path=%s", $this->path);
        }

        if ($this->expires) {
            $cookieStringParts[] = sprintf("Expires=%s", gmdate('D, d M Y H:i:s T', $this->expires));
        }

        if ($this->maxAge) {
            $cookieStringParts[] = sprintf("Max-Age=%s", $this->maxAge);
        }

        if ($this->secure) {
            $cookieStringParts[] = 'Secure';
        }

        if ($this->httpOnly) {
            $cookieStringParts[] = 'HttpOnly';
        }

        return implode('; ', $cookieStringParts);
    }

    public static function create($name)
    {
        return new static($name);
    }

    public static function fromSetCookieString($string)
    {
        $rawAttributes = StringUtil::splitOnAttributeDelimiter($string);

        list ($cookieName, $cookieValue) = StringUtil::splitCookiePair(array_shift($rawAttributes));

        /** @var SetCookie $setCookie */
        $setCookie = new static($cookieName);

        if (! is_null($cookieValue)) {
            $setCookie = $setCookie->withValue($cookieValue);
        }

        while ($rawAttribute = array_shift($rawAttributes)) {
            $rawAttributePair = explode('=', $rawAttribute, 2);

            $attributeKey = $rawAttributePair[0];
            $attributeValue = count($rawAttributePair) > 1 ? $rawAttributePair[1] : null;

            $attributeKey = strtolower($attributeKey);

            switch($attributeKey) {
                case 'expires':
                    $setCookie = $setCookie->withExpires($attributeValue);
                    break;
                case 'max-age':
                    $setCookie = $setCookie->withMaxAge($attributeValue);
                    break;
                case 'domain':
                    $setCookie = $setCookie->withDomain($attributeValue);
                    break;
                case 'path':
                    $setCookie = $setCookie->withPath($attributeValue);
                    break;
                case 'secure':
                    $setCookie = $setCookie->withSecure(true);
                    break;
                case 'httponly':
                    $setCookie = $setCookie->withHttpOnly(true);
                    break;
            }

        }

        return $setCookie;
    }
}
