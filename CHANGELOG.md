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
  inheriting from.
- [#31](https://github.com/dflydev/dflydev-fig-cookies/pull/32) A new abstraction was
  introduced to support `SameSite=Lax` and `SameSite=Strict` `Set-Cookie` header modifiers.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#31](https://github.com/dflydev/dflydev-fig-cookies/pull/32) `SetCookie#withExpires()`
  will now reject any expiry time that cannot be parsed into a timestamp.
- [#31](https://github.com/dflydev/dflydev-fig-cookies/pull/32) A `SetCookie` can no longer
  be constructed via `Dflydev\FigCookies\SetCookie::fromSetCookieString('')`: an empty string
  will now be rejected.
