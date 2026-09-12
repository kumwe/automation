# Architecture and ownership

Automation owns cron matching, retry policy, immutable job/lease state and portable job, queue, schedule and store contracts. It imports canonical Contribution, Access Context and Canonical JSON abstractions directly. It does not implement a JSON encoder, queue adapter, durable worker, trusted-generation selector or host deadline enforcement.

Cron scheduling walks UTC instants and matches each instant in the requested IANA timezone. The two occurrences of a repeated local minute are distinct due times; nonexistent local minutes have no occurrence. Search is bounded to five years, expressions to 1024 bytes, and field expansion to each field's range. Retry delays double until the configured cap without overflowing or saturating early at odd caps.

ConfigProvider and explicit Container factories are the sole PSR-11 boundary. Factories resolve the host-selected clock, jitter and explicit handler IDs. They do not discover handlers, admit trust, start workers or read ambient configuration. Domain services never receive a container.

Public types retain their source and test mappings. Composition types are package-owned runtime support,
recorded without invented App source provenance. Library tests own behavior and DI invariants. Core retains
database contention, fencing, worker restart, stale generation, transaction and lifecycle acceptance evidence.
