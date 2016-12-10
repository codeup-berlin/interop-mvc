# MVC interoperability

Inspired by the work of [PHP-FIG](http://www.php-fig.org/) and
[container-interop](https://github.com/container-interop/container-interop) *interop-mvc* tries to fill the gap to
decouple MVC application code from framework specific dependencies. The main motivation is to make the MVC framework
used for bootstrapping and routing simply exchangeable. 

## Installation

To install this library through [Composer](https://getcomposer.org/) use:

```json
composer require codeup/interop-mvc
```

This library releases are versioned according [Semantic Versioning](http://semver.org/) specification to provide full
backward compatibility between minor versions.
