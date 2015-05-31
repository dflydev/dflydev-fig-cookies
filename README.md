FIG Cookies
===========

Managing Cookies for PSR-7 Requests and Responses.

[![Latest Stable Version](https://poser.pugx.org/dflydev/fig-cookies/v/stable)](https://packagist.org/packages/dflydev/fig-cookies)
[![Total Downloads](https://poser.pugx.org/dflydev/fig-cookies/downloads)](https://packagist.org/packages/dflydev/fig-cookies)
[![Latest Unstable Version](https://poser.pugx.org/dflydev/fig-cookies/v/unstable)](https://packagist.org/packages/dflydev/fig-cookies)
[![License](https://poser.pugx.org/dflydev/fig-cookies/license)](https://packagist.org/packages/dflydev/fig-cookies)
<br>
[![Build Status](https://travis-ci.org/dflydev/dflydev-fig-cookies.svg?branch=master)](https://travis-ci.org/dflydev/dflydev-fig-cookies)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dflydev/dflydev-fig-cookies/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dflydev/dflydev-fig-cookies/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/dflydev/dflydev-fig-cookies/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/dflydev/dflydev-fig-cookies/?branch=master)
[![Code Climate](https://codeclimate.com/github/dflydev/dflydev-fig-cookies/badges/gpa.svg)](https://codeclimate.com/github/dflydev/dflydev-fig-cookies)
<br>
[![Join the chat at https://gitter.im/dflydev/dflydev-fig-cookies](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/dflydev/dflydev-fig-cookies?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)


Requirements
------------

 * PHP 5.4+
 * [psr/http-message](https://packagist.org/packages/psr/http-message)


Installation
------------

```bash
$> composer require dflydev/fig-cookies
```

While in early development, you may be required to be a little more specific:

```bash
$> composer require dflydev/fig-cookies:^0.0@dev
```


Concepts
--------

FIG Cookies tackles two problems, managing **Cookie** *Request* headers and
managing **Set-Cookie** *Response* headers. It does this by way of introducing
a `Cookies` class to manage collections of `Cookie` instances and a
`SetCookies` class to manage collections of `SetCookie` instances.

Instantiating these collections looks like this:

```php
// Get a collection representing the cookies in the Cookie headers
// of a PSR-7 Request.
$cookies = Dflydev\FigCookies\Cookies::fromRequest($request);

// Get a collection representing the cookies in the Set-Cookie headers
// of a PSR-7 Response
$setCookies = Dflydev\FigCookies\SetCookies::fromResponse($response);
```

After modifying these collections in some way, they are rendered into a
PSR-7 Request or PSR-7 Response like this:

```php
// Render the Cookie headers and add them to the headers of a
// PSR-7 Request.
$request = $cookies->renderIntoRequest($request);

// Render the Set-Cookie headers and add them to the headers of a
// PSR-7 Response.
$response = $setCookies->renderIntoResponse($response);
```

Like PSR-7 Messages, `Cookie`, `Cookies`, `SetCookie`, and `SetCookies`
are all represented as immutable value objects and all mutators will
return new instances of the original with the requested changes.

While this style of design has many benefits it can become fairly
verbose very quickly. In order to get around that, FIG Cookies provides
a facade named `FigCookies` in an attempt to help simply things and make
the whole process less verbose.


Basic Usage
-----------

The easiest way to start working with FIG Cookies is by using the `FigCookies`
class. It is a facade to the primitive FIG Cookies classes. Its job is to
make common tasks easier and less verbose.

There is overhead on creating `Cookies` and `SetCookies` and rebuilding
requests and responses. Each of the `FigCookies` methods that cause mutations
will go through this process so be wary of using too many of these calls in
the same section of code. In some cases it may be better to work with the
primitive FIG Cookies classes directly rather than using the facade.


### Request Cookies

#### Get a Cookie from a Request

The `getRequestCookie` method will return a `Cookie` instance that represents
a cookie that exists in the request's headers. If no cookie by the specified
name exists, the `Cookie` instance will have a `null` value.

The optional third parameter to `getRequestCookie` sets the value that
should be used if a cookie does not exist.

```php
use Dflydev\FigCookies\FigCookie;

$cookie = FigCookies::getRequestCookie($request, 'theme');
$cookie = FigCookies::getRequestCookie($request, 'theme', 'default-theme');
```

#### Set a Cookie on a Request

The `setRequestCookie` will either add or replace an existing cookie.

The `Cookie` primitive is used here for consistency with how
`setResponseSetCookie` is called.

```php
use Dflydev\FigCookies\FigCookie;

$request = FigCookies::setRequestCookie($request, Cookie::create('theme', 'blue'));
```

#### Modify a Cookie on a Request

Sometimes the current value of a cookie needs to be known before it can be set.
`modifyRequestCookie` accepts a call back that accepts a Cookie instance that
represents the current cookie on the request and is expected to return an
instance of Cookie that should be set on the request.

```php
use Dflydev\FigCookies\FigCookie;

$modify = function (Cookie $cookie) {
    $value = $cookie->getValue();

    // ... inspect current $value and determine if $value should
    // change or if it can stay the same. in all cases, a cookie
    // should be returned from this callback...

    return $cookie->withValue($value);
}

$request = FigCookies::modifyRequestCookie($request, 'theme', $modify);
```

#### Remove a Cookie from a Request

The `removeRequestCookie` removes a cookie from the request if it exists.

```php
use Dflydev\FigCookies\FigCookie;

$request = FigCookies::removeRequestCookie($request, 'theme');
```

### Response Cookies

#### Get a SetCookie from a Response

The `getResponseSetCookie` method will return a `SetCookie` instance that
represents a cookie that exists in the response's headers. If no cookie by the
specified name exists, the `SetCookie` instance will have a `null` value.

The optional third parameter to `getResponseSetCookie` sets the value that
should be used if a cookie does not exist.

```php
use Dflydev\FigCookies\FigCookie;

$setCookie = FigCookies::getResponseSetCookie($response, 'theme');
$setCookie = FigCookies::getResponseSetCookie($response, 'theme', 'simple');
```

#### Set a SetCookie on a Response

The `setResponseSetCookie` will either add or replace an existing cookie.

```php
use Dflydev\FigCookies\FigCookie;

$response = FigCookies::setResponseSetCookie($response, SetCookie::create('token')
    ->withValue('a9s87dfz978a9')
    ->withDomain('example.com')
    ->withPath('/firewall')
);
```

#### Modify a SetCookie on a Response

Sometimes the current value of a cookie needs to be known before it can be set.
`modifyResponseSetCookie` accepts a call back that accepts a SetCookie instance
that represents the current cookie on the response and is expected to return an
instance of SetCookie that should be set on the response.

```php
use Dflydev\FigCookies\FigCookie;

$modify = function (SetCookie $setCookie) {
    $value = $setCookie->getValue();

    // ... inspect current $value and determine if $value should
    // change or if it can stay the same. in all cases, a cookie
    // should be returned from this callback...

    return $setCookie
        ->withValue($newValue)
        ->withExpires($newExpires)
    ;
}

$response = FigCookies::modifyResponseSetCookie($response, 'theme', $modify);
```

#### Remove a SetCookie from a Response

The `removeResponseSetCookie` removes a cookie from the response if it exists.

```php
use Dflydev\FigCookies\FigCookie;

$response = FigCookies::removeResponseSetCookie($response, 'theme');
```


FAQ
---

### Do you call `setcookies`?

No.

Delivery of the rendered `SetCookie` instances is the responsibility of the
PSR-7 client implementation.


### Do you do anything with sessions?

No.

It would be possible to build session handling using cookies on top of FIG
Cookies but it is out of scope for this package.


### Do you read from `$_COOKIES`?

No.

FIG Cookies only pays attention to the `Cookie` headers on PSR-7 Request
instances. In the case of `ServerRequestInterface` instances, PSR-7
implementations should be including `$_COOKIES` values in the headers
so in that case FIG Cookies may be interacting with `$_COOKIES`
indirectly.


License
-------

MIT, see LICENSE.


Community
---------

Want to get involved? Here are a few ways:

 * Find us in the #dflydev IRC channel on irc.freenode.org.
 * Mention [@dflydev](https://twitter.com/dflydev) on Twitter.
 * [![Join the chat at https://gitter.im/dflydev/dflydev-fig-cookies](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/dflydev/dflydev-fig-cookies?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
