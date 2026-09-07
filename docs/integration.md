# Standalone use and host composition

Install with Composer and use the canonical Kumwe\\Automation types directly. PHP 8.5 and the declared dependencies are required. Run `php examples/consumer.php` for a deterministic schedule declaration without App.

For Laminas/Mezzio, include `Kumwe\\Automation\\ConfigProvider::class` explicitly in the ConfigAggregator provider list. Pass the aggregated `dependencies` map to Laminas ServiceManager and register the full aggregated array under `config`. No provider auto-discovery is performed.

| Service | Factory | Lifetime |
| --- | --- | --- |
| CryptographicJitterSource | Container\\CryptographicJitterSourceFactory | Shared, stateless |
| RetryPolicy | Container\\RetryPolicyFactory | Shared, injected clock/jitter |
| JobHandlerRegistry | Container\\JobHandlerRegistryFactory | Shared, fixed explicit handler set |

`JitterSource` aliases `CryptographicJitterSource`; override the interface intentionally if the host requires a different source. The host must provide `Psr\\Clock\\ClockInterface`. No default clock captures deployment-specific time policy.

Options under `kumwe.automation` are `base_delay_seconds` (integer, default 1), `maximum_delay_seconds` (integer at least the base, default 300), and `handlers` (list of explicitly registered handler service IDs, default empty). Invalid options or wrong dependency types raise InvalidArgumentException; missing services preserve PSR container errors. Every configured service must implement JobHandler. Duplicate job types are refused by the registry.

Values, job envelopes and operation contexts are constructed per operation and never retained in shared services. Host workers supply execution context, durable queue transactions and trusted-generation fencing. Source mappings and test ownership remain in resources/migration; adopt a separately verified immutable release before removing mapped App classes and only their portable assertions.

Run `composer check` for source, API/member docs, ownership, architecture, static/style, behavior, examples, audit, archive-consumer and release-regression gates.
