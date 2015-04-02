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
        if ($this->hasValueEqualTo($value)) {
            return $this;
        }

        return $this->cloneWithValue($value);
    }

    public function withExpires($expires = null)
    {
        if (! is_null($expires)) {
            $expires = is_numeric($expires) ? $expires : strtotime($expires);
        }

        if ($this->hasExpiresEqualTo($expires)) {
            return $this;
        }

        return $this->cloneWithExpires($expires);
    }

    public function withMaxAge($maxAge = null)
    {
        if ($this->hasMaxAgeEqualTo($maxAge)) {
            return $this;
        }

        return $this->cloneWithMaxAge($maxAge);
    }

    public function withPath($path = null)
    {
        if ($this->hasPathEqualTo($path)) {
            return $this;
        }

        return $this->cloneWithPath($path);
    }

    public function withDomain($domain = null)
    {
        if ($this->hasDomainEqualTo($domain)) {
            return $this;
        }

        return $this->cloneWithDomain($domain);
    }

    public function withSecure($secure = null)
    {
        if ($this->hasSecureEqualTo($secure)) {
            return $this;
        }

        return $this->cloneWithSecure($secure);
    }

    public function withHttpOnly($httpOnly = null)
    {
        if ($this->hasHttpOnlyEqualTo($httpOnly)) {
            return $this;
        }

        return $this->cloneWithHttpOnly($httpOnly);
    }

    public function __toString()
    {
        $cookieStringParts = [
            urlencode($this->name).'='.urlencode($this->value),
        ];

        $cookieStringParts = $this->appendFormattedDomainPartIfSet($cookieStringParts);
        $cookieStringParts = $this->appendFormattedPathPartIfSet($cookieStringParts);
        $cookieStringParts = $this->appendFormattedExpiresPartIfSet($cookieStringParts);
        $cookieStringParts = $this->appendFormattedMaxAgePartIfSet($cookieStringParts);
        $cookieStringParts = $this->appendFormattedSecurePartIfSet($cookieStringParts);
        $cookieStringParts = $this->appendFormattedHttpOnlyPartIfSet($cookieStringParts);

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

    private function hasExpiresEqualTo($expires = null)
    {
        return $expires === $this->expires;
    }

    private function cloneWithExpires($expires = null)
    {
        $clone = clone($this);

        $clone->expires = $expires;

        return $clone;
    }

    private function hasMaxAgeEqualTo($maxAge)
    {
        return $maxAge === $this->maxAge;
    }

    private function cloneWithMaxAge($maxAge = null)
    {
        $clone = clone($this);

        $clone->maxAge = $maxAge;

        return $clone;
    }

    private function hasPathEqualTo($path = null)
    {
        return $path === $this->path;
    }

    private function cloneWithPath($path = null)
    {
        $clone = clone($this);

        $clone->path = $path;

        return $clone;
    }

    private function hasDomainEqualTo($domain = null)
    {
        return $domain === $this->domain;
    }

    private function cloneWithDomain($domain = null)
    {
        $clone = clone($this);

        $clone->domain = $domain;

        return $clone;
    }

    private function hasSecureEqualTo($secure = null)
    {
        return $secure === $this->secure;
    }

    private function cloneWithSecure($secure = null)
    {
        $clone = clone($this);

        $clone->secure = $secure;

        return $clone;
    }

    private function hasHttpOnlyEqualTo($httpOnly = null)
    {
        return $httpOnly === $this->httpOnly;
    }

    private function cloneWithHttpOnly($httpOnly = null)
    {
        $clone = clone($this);

        $clone->httpOnly = $httpOnly;

        return $clone;
    }

    private function appendFormattedDomainPartIfSet(array $cookieStringParts)
    {
        if ($this->domain) {
            $cookieStringParts[] = sprintf("Domain=%s", $this->domain);
        }

        return $cookieStringParts;
    }

    private function appendFormattedPathPartIfSet(array $cookieStringParts)
    {
        if ($this->path) {
            $cookieStringParts[] = sprintf("Path=%s", $this->path);
        }

        return $cookieStringParts;
    }

    private function appendFormattedExpiresPartIfSet(array $cookieStringParts)
    {
        if ($this->expires) {
            $cookieStringParts[] = sprintf("Expires=%s", gmdate('D, d M Y H:i:s T', $this->expires));
        }

        return $cookieStringParts;
    }

    private function appendFormattedMaxAgePartIfSet(array $cookieStringParts)
    {
        if ($this->maxAge) {
            $cookieStringParts[] = sprintf("Max-Age=%s", $this->maxAge);
        }

        return $cookieStringParts;
    }

    private function appendFormattedSecurePartIfSet(array $cookieStringParts)
    {
        if ($this->secure) {
            $cookieStringParts[] = 'Secure';
        }

        return $cookieStringParts;
    }

    private function appendFormattedHttpOnlyPartIfSet(array $cookieStringParts)
    {
        if ($this->httpOnly) {
            $cookieStringParts[] = 'HttpOnly';
        }

        return $cookieStringParts;
    }
}
