FIG Cookies
===========

Managing Cookies for PSR-7 Requests and Responses.

# Accessing cookies from Request

```php
use Dflydev\FigCookies\Cookies;

// $request = a psr7request;
$cookies = Cookies::fromRequest($request);
```

## Check a cookie exists

You can check whether a cookie by name exists via `has` method which returns `bool`.

```php
$cookies->has('name');
```

## Get cookie

You can get a `Cookie` object via `get` method.

```php
$cookie = $cookies->get('name');
```

This will return a `Dflydev\FigCookies\Cookie` object via which you can get
name, value etc via `getName()` and `getValue()` respectively.

## Change cookie value

You can change the value of a cookie via `withValue` method.

```php
$cookie->withValue('some value');
```

or alternatively you can create a fresh cookie object via

```php
use Dflydev\FigCookies\Cookie;

$cookie = new Cookie('name');
// or
// $cookie = Cookie::create('name');

$cookie->withValue('some value');
```

## Setting cookie to header

```php
use Dflydev\FigCookies\SetCookie;
use Dflydev\FigCookies\Cookies;

// $request = a psr7request

$cookie = SetCookie::create('lu')
    ->withValue('Rg3vHJZnehYLjVg7qi3bZjzg')
    ->withExpires('Tue, 15-Jan-2013 21:47:38 GMT')
    ->withMaxAge(500)
    ->withPath('/')
    ->withDomain('.example.com')
    ->withSecure(true)
    ->withHttpOnly(true);

$request = $request->withHeader(Cookies::COOKIE_HEADER, $cookie->__toString());
```
