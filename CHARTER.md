# Automation ownership charter

Automation owns portable cron, retry, deadline, job, queue, schedule, lease and outcome semantics
under the canonical namespace `Kumwe\Automation`.

## Host responsibilities

Core and other hosts own worker daemons, schedulers, infrastructure adapters, trusted handler selection,
transactions, telemetry and tenant authority. Production package code never imports Kumwe App.

## Package contract

The package owns portable behavior, boundary and conformance tests, public API manifests, archive
verification and consumer examples. [The release contract record](docs/release-record.md) preserves
source provenance, symbol mappings and compatibility requirements.

Consumers use independently verified immutable releases and retain host integration tests when changing
an exact package pin. Package publication does not establish consumer integration. Each portable symbol
has one canonical owner; namespace aliases, copied vendor implementations and silent runtime fallbacks
are prohibited.
