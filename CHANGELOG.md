# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.0.0 - 2018-07-11

### Added

- [#32](https://github.com/dflydev/dflydev-fig-cookies/pull/32) all public API of the
  project now has extensive parameter and return type declarations.
  If you are using the library with `declare(strict_types=1);` in your codebase, you
  will need to run static analysis against your code to find possible type incompatibilities
  in method calls.
  If you are inheriting any of your code from this library, you will need to check
  that your type signatures respect variance and covariance with the symbols you are
  inheriting from. Here is a full list of the changes:
    ```
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\Cookie#__construct() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\Cookie#__construct() changed from no type to a non-contravariant ?string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\Cookie#__construct() changed from no type to string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\Cookie#__construct() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookie#getName() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookie#getValue() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookie#withValue() changed from no type to Dflydev\FigCookies\Cookie
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\Cookie#withValue() changed from no type to a non-contravariant ?string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\Cookie#withValue() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookie#__toString() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookie::create() changed from no type to Dflydev\FigCookies\Cookie
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\Cookie::create() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\Cookie::create() changed from no type to a non-contravariant ?string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\Cookie::create() changed from no type to string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\Cookie::create() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookie::listFromCookieString() changed from no type to array
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\Cookie::listFromCookieString() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\Cookie::listFromCookieString() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookie::oneFromCookiePair() changed from no type to Dflydev\FigCookies\Cookie
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\Cookie::oneFromCookiePair() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\Cookie::oneFromCookiePair() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\FigRequestCookies::get() changed from no type to Dflydev\FigCookies\Cookie
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigRequestCookies::get() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\FigRequestCookies::get() changed from no type to a non-contravariant ?string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigRequestCookies::get() changed from no type to string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\FigRequestCookies::get() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\FigRequestCookies::set() changed from no type to Psr\Http\Message\RequestInterface
    [BC] CHANGED: The return type of Dflydev\FigCookies\FigRequestCookies::modify() changed from no type to Psr\Http\Message\RequestInterface
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigRequestCookies::modify() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $modify of Dflydev\FigCookies\FigRequestCookies::modify() changed from no type to a non-contravariant callable
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigRequestCookies::modify() changed from no type to string
    [BC] CHANGED: The parameter $modify of Dflydev\FigCookies\FigRequestCookies::modify() changed from no type to callable
    [BC] CHANGED: The return type of Dflydev\FigCookies\FigRequestCookies::remove() changed from no type to Psr\Http\Message\RequestInterface
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigRequestCookies::remove() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigRequestCookies::remove() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookies#has() changed from no type to bool
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookies#has() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookies#has() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookies#get() changed from no type to ?Dflydev\FigCookies\SetCookie
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookies#get() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookies#get() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookies#getAll() changed from no type to array
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookies#with() changed from no type to Dflydev\FigCookies\SetCookies
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookies#without() changed from no type to Dflydev\FigCookies\SetCookies
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookies#without() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookies#without() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookies#renderIntoSetCookieHeader() changed from no type to Psr\Http\Message\ResponseInterface
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookies::fromSetCookieStrings() changed from no type to self
    [BC] CHANGED: The parameter $setCookieStrings of Dflydev\FigCookies\SetCookies::fromSetCookieStrings() changed from no type to a non-contravariant array
    [BC] CHANGED: The parameter $setCookieStrings of Dflydev\FigCookies\SetCookies::fromSetCookieStrings() changed from no type to array
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookies::fromResponse() changed from no type to Dflydev\FigCookies\SetCookies
    [BC] CHANGED: The return type of Dflydev\FigCookies\StringUtil::splitOnAttributeDelimiter() changed from no type to array
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\StringUtil::splitOnAttributeDelimiter() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\StringUtil::splitOnAttributeDelimiter() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\StringUtil::splitCookiePair() changed from no type to array
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\StringUtil::splitCookiePair() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\StringUtil::splitCookiePair() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#getName() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#getValue() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#getExpires() changed from no type to int
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#getMaxAge() changed from no type to int
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#getPath() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#getDomain() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#getSecure() changed from no type to bool
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#getHttpOnly() changed from no type to bool
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#withValue() changed from no type to self
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\SetCookie#withValue() changed from no type to a non-contravariant ?string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\SetCookie#withValue() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#withExpires() changed from no type to self
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#rememberForever() changed from no type to self
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#expire() changed from no type to self
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#withMaxAge() changed from no type to self
    [BC] CHANGED: The parameter $maxAge of Dflydev\FigCookies\SetCookie#withMaxAge() changed from no type to a non-contravariant ?int
    [BC] CHANGED: The parameter $maxAge of Dflydev\FigCookies\SetCookie#withMaxAge() changed from no type to ?int
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#withPath() changed from no type to self
    [BC] CHANGED: The parameter $path of Dflydev\FigCookies\SetCookie#withPath() changed from no type to a non-contravariant ?string
    [BC] CHANGED: The parameter $path of Dflydev\FigCookies\SetCookie#withPath() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#withDomain() changed from no type to self
    [BC] CHANGED: The parameter $domain of Dflydev\FigCookies\SetCookie#withDomain() changed from no type to a non-contravariant ?string
    [BC] CHANGED: The parameter $domain of Dflydev\FigCookies\SetCookie#withDomain() changed from no type to ?string
    [BC] CHANGED: Default parameter value for for parameter $secure of Dflydev\FigCookies\SetCookie#withSecure() changed from NULL to true
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#withSecure() changed from no type to self
    [BC] CHANGED: The parameter $secure of Dflydev\FigCookies\SetCookie#withSecure() changed from no type to a non-contravariant bool
    [BC] CHANGED: The parameter $secure of Dflydev\FigCookies\SetCookie#withSecure() changed from no type to bool
    [BC] CHANGED: Default parameter value for for parameter $httpOnly of Dflydev\FigCookies\SetCookie#withHttpOnly() changed from NULL to true
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#withHttpOnly() changed from no type to self
    [BC] CHANGED: The parameter $httpOnly of Dflydev\FigCookies\SetCookie#withHttpOnly() changed from no type to a non-contravariant bool
    [BC] CHANGED: The parameter $httpOnly of Dflydev\FigCookies\SetCookie#withHttpOnly() changed from no type to bool
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie#__toString() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie::create() changed from no type to self
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookie::create() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\SetCookie::create() changed from no type to a non-contravariant ?string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookie::create() changed from no type to string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\SetCookie::create() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie::createRememberedForever() changed from no type to self
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookie::createRememberedForever() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\SetCookie::createRememberedForever() changed from no type to a non-contravariant ?string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookie::createRememberedForever() changed from no type to string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\SetCookie::createRememberedForever() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie::createExpired() changed from no type to self
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookie::createExpired() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\SetCookie::createExpired() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\SetCookie::fromSetCookieString() changed from no type to self
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\SetCookie::fromSetCookieString() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\SetCookie::fromSetCookieString() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\FigResponseCookies::get() changed from no type to Dflydev\FigCookies\SetCookie
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigResponseCookies::get() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\FigResponseCookies::get() changed from no type to a non-contravariant ?string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigResponseCookies::get() changed from no type to string
    [BC] CHANGED: The parameter $value of Dflydev\FigCookies\FigResponseCookies::get() changed from no type to ?string
    [BC] CHANGED: The return type of Dflydev\FigCookies\FigResponseCookies::set() changed from no type to Psr\Http\Message\ResponseInterface
    [BC] CHANGED: The return type of Dflydev\FigCookies\FigResponseCookies::expire() changed from no type to Psr\Http\Message\ResponseInterface
    [BC] CHANGED: The parameter $cookieName of Dflydev\FigCookies\FigResponseCookies::expire() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $cookieName of Dflydev\FigCookies\FigResponseCookies::expire() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\FigResponseCookies::modify() changed from no type to Psr\Http\Message\ResponseInterface
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigResponseCookies::modify() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $modify of Dflydev\FigCookies\FigResponseCookies::modify() changed from no type to a non-contravariant callable
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigResponseCookies::modify() changed from no type to string
    [BC] CHANGED: The parameter $modify of Dflydev\FigCookies\FigResponseCookies::modify() changed from no type to callable
    [BC] CHANGED: The return type of Dflydev\FigCookies\FigResponseCookies::remove() changed from no type to Psr\Http\Message\ResponseInterface
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigResponseCookies::remove() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\FigResponseCookies::remove() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookies#has() changed from no type to bool
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\Cookies#has() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\Cookies#has() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookies#get() changed from no type to ?Dflydev\FigCookies\Cookie
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\Cookies#get() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\Cookies#get() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookies#getAll() changed from no type to array
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookies#with() changed from no type to Dflydev\FigCookies\Cookies
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookies#without() changed from no type to Dflydev\FigCookies\Cookies
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\Cookies#without() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $name of Dflydev\FigCookies\Cookies#without() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookies#renderIntoCookieHeader() changed from no type to Psr\Http\Message\RequestInterface
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookies::fromCookieString() changed from no type to self
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\Cookies::fromCookieString() changed from no type to a non-contravariant string
    [BC] CHANGED: The parameter $string of Dflydev\FigCookies\Cookies::fromCookieString() changed from no type to string
    [BC] CHANGED: The return type of Dflydev\FigCookies\Cookies::fromRequest() changed from no type to Dflydev\FigCookies\Cookies
    ```
    
- [#31](https://github.com/dflydev/dflydev-fig-cookies/pull/31) A new abstraction was
  introduced to support `SameSite=Lax` and `SameSite=Strict` `Set-Cookie` header modifiers.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#32](https://github.com/dflydev/dflydev-fig-cookies/pull/32) `SetCookie#withExpires()`
  will now reject any expiry time that cannot be parsed into a timestamp.
- [#32](https://github.com/dflydev/dflydev-fig-cookies/pull/32) A `SetCookie` can no longer
  be constructed via `Dflydev\FigCookies\SetCookie::fromSetCookieString('')`: an empty string
  will now be rejected.
