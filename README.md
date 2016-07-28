# Slim Boilerplate

| Version      | 1.0.0           |
|--------------|-----------------|
| Release Date | 28 July 2016    |
| Author       | Enrico Deleo    |
| Author URL   | [enricodeleo.com](http://enricodeleo.com) |

Use this boilerplate to quickly setup and start working on a new landing page.
This application uses the latest [Slim 3 framework](http://www.slimframework.com/) with the twig-view template renderer. It also uses the Monolog logger.

This application was built for Composer. This makes setting up a new application quick and easy.

## Prerequisites

* PHP >= 5.5
* Composer
* MySQL, MSSQL or SQLite [optional] - just if you need persistent data

## Main features

* CSFR (protection against Cross-site request forgery)
* SQL-like database abstraction layer via [medoo](http://medoo.in/)
* Email service powered by [PHPMailer](https://github.com/PHPMailer/PHPMailer) and SendGrid
* Logging
* Smart templating with [Twig](http://twig.sensiolabs.org/)
* Dependencies management via [composer](https://getcomposer.org/)

## Install the Application

Clone this repo and run this command from its directory:

```bash
composer install
```

## Local preview

Start a php local server with:

```bash
php -S localhost:8000 -t public/
```

## Production

The webserver should point the document root to the `public/` directory.

Note that `logs/` must be writeable by the same user running the server to write logs correctly.

## Opinionated

This boilerplate already include and implements libraries in order to give immediate access to common features like sending emails or persisting data on a database. Please read comments throughout the code to have some hint. Of course you can remove and/or switch features at any moment and suggest me better solutions!

## Slim Framework documentation

Refer to the [Slim 3 framework](http://www.slimframework.com/) documentation.

## Changelog

## [1.0.0] - 2015-07-28
### Added
- Twig template engine
- Database abstraction layer with on the fly table/schemas creation
- Email service
- CSFR protection
- User IP middleware
- Landing page example with signup, email confirmation and db persistence