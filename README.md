# Kumwe Automation

[![Latest version][version-badge]][package]
[![Automation CI][ci-badge]][ci]
[![PHP requirement][php-badge]][package]
[![License][license-badge]](LICENSE)

Portable cron scheduling, immutable job state and leases, injected clock/jitter retry policy,
queue policies, handler and storage ports, and job, queue and schedule declarations.

## Installation

```bash
composer require kumwe/automation:0.2.2
```

Requires PHP `^8.5`, the exact Kumwe dependencies declared in [composer.json](composer.json),
PSR Clock and PSR Container. Consumers pin pre-1.0 Kumwe packages to independently verified exact versions.

```php
use Kumwe\Automation\CronExpression;

$next = (new CronExpression('0 8 * * 1-5'))->next(
    new DateTimeImmutable('2026-09-07T05:00:00Z'),
    'Africa/Windhoek',
);
echo $next->format(DATE_ATOM); // 2026-09-07T06:00:00+00:00
```

Run the [standalone example](examples/consumer.php) with `composer examples` from a development checkout,
or pass a consuming application's autoloader to the installed example as described in
[host composition](docs/integration.md).

## Contract with Kumwe Core

Automation owns portable schedule, retry, job, lease and declaration semantics. Core owns worker loops,
OS signals, runtime deadline enforcement, scheduler execution, trusted handler selection, durable
queues, database coordination, tenant authority and lifecycle.

JSON-dependent constructors and factories require `Kumwe\CanonicalJson\CanonicalEncoder` explicitly.
Core supplies its encoder; this package contains no encoder executor. Declaration inputs reject floats,
objects, resources, depth over 32 and collections over 512 before invoking that encoder. Job payloads
and event envelopes retain their separate documented profiles and limits.

The optional `ConfigProvider` and explicit container factories support Laminas/Mezzio composition.
Core supplies the clock, jitter policy and explicitly admitted handler services. Factories do not
discover handlers, admit trust or start workers. See [integration](docs/integration.md) for bindings,
configuration, lifetimes and error behavior.

## API and development

The [public API](docs/public-api.md), [architecture](docs/architecture.md) and
[charter](CHARTER.md) define the maintained package surface and ownership boundary.
Public signatures and neutral ports are checked against the API and service-map manifests.
The [release contract record](docs/release-record.md) preserves source mappings, manifest digests,
compatibility requirements and independent verification obligations for consumers.

```bash
composer install
composer check
```

The complete gate verifies source, manifests, static analysis, style, behavior, test ownership,
examples, dependency security and release automation. `composer clean-consumer` builds a ZIP,
installs it into a fresh Composer consumer and runs behavior and example checks through that
consumer's authoritative autoloader. Explicit development overrides are documented in
[the integration guide](docs/integration.md).

## Releases and license

The version badge tracks Packagist and the CI badge tracks the actual default-branch workflow.
Publication and passing package checks do not establish Core adoption or independent release verification.
See [release policy](docs/releasing.md) for exact pins, immutable artifact identity and consumer evidence.

Licensed under [Apache-2.0](LICENSE).

[version-badge]: https://img.shields.io/packagist/v/kumwe/automation
[package]: https://packagist.org/packages/kumwe/automation
[ci-badge]: https://github.com/kumwe/automation/actions/workflows/ci.yml/badge.svg?branch=main
[ci]: https://github.com/kumwe/automation/actions/workflows/ci.yml
[php-badge]: https://img.shields.io/packagist/dependency-v/kumwe/automation/php
[license-badge]: https://img.shields.io/packagist/l/kumwe/automation
