# Dashboard

[![Build Status](https://travis-ci.org/Zarthus/dashboard.svg?branch=master)](https://travis-ci.org/Zarthus/dashboard)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg)]()
[![GitHub release](https://img.shields.io/github/release/zarthus/dashboard.svg)]()

It's a dashboard application with configuration, extensibility, and minimalism in mind.

Dash tries to offer extensibility through having a series of configuration
files and gitignore flexibility. It means you can still freely fetch updates
from git so long as you follow the folder structure conventions.

## Installation

For development, I recommend the docker setup.

- Generate the TLS certificate with `.docker/nginx/cert_generate.sh`
- Adjust `/etc/hosts` to point `dash.dev` to `0.0.0.0`
- `composer install`
- Run `docker-compose up -d`
- Navigate to https://dash.dev (consider adding the cert to your trust store)

Production use requires PHP 7.1, composer, and a webserver pointing
everything towards `public/index.php`

### Key features

- Extensibility, a lot of things can have third-party additions to them
- Configurable, easy and fast to set up: Because a lot is prewritten for you,
  an out of the box installation will set you up with a pretty decent dashboard.
- Cache granularity: A lot of content is cached to ensure fast responses on heavier
  modules, however you can still freely adjust the cache time-to-live to meet your preferences.

### Key limitations

- Only (truly) support for one dashboard at the moment. The limitation is within the router.
- If you depend on a dependency adjusting composer.json is difficult.
- No database support, you can however create files within var/cache.
- Difficult to version control unofficial components natively.

### Unofficial namespace

Currently, you can add the following under the "Unofficial" namespaces:

- Your own modules
  - Your own unit tests
- Your own css themes (they have to be bulma or implement a large part of the bulma framework)
- Your own layouts and templates
- Your own documentation

## Documentation

Documentation for configuring modules is provided in `docs/`

# License

Dash is licensed under the [MIT license](LICENSE).
