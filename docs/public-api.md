# Public runtime API

Constructors and factories validate source invariants. JSON-taking entry points require an explicit `CanonicalEncoder`. No service provider installs these types into a host. The machine-readable manifest records exact public methods, parameters, return types, constants and interfaces.

| Symbol | Kind | Public members declared here |
| --- | --- | --- |
| `Kumwe\Automation\AutomationNotFound` | class |  |
| `Kumwe\Automation\CronExpression` | class | `__construct()`, `__toString()`, `next()` |
| `Kumwe\Automation\CryptographicJitterSource` | class | `between()` |
| `Kumwe\Automation\ExpiredJobLease` | class |  |
| `Kumwe\Automation\FailureClassification` | enum | `cases()`, `from()`, `tryFrom()` |
| `Kumwe\Automation\JitterSource` | interface | `between()` |
| `Kumwe\Automation\JobContributionDefinition` | class | `__construct()`, `fromArray()`, `handlerVersion()`, `identifier()`, `installationWide()`, `maximumAttempts()`, `payloadSchema()`, `queue()`, `schemaVersion()`, `toArray()` |
| `Kumwe\Automation\JobDeclaration` | class | `fromManifest()`, `schemaVersion()`, `toArray()`, `type()` |
| `Kumwe\Automation\JobEnvelope` | class | `attempts()`, `availableAt()`, `claim()`, `complete()`, `createdAt()`, `id()`, `isClaimableAt()`, `lease()`, `maximumAttempts()`, `payload()`, `pending()`, `priority()`, `queue()`, `releaseExpiredLease()`, `releaseForRetry()`, `renewLease()`, `schemaVersion()`, `status()`, `type()` |
| `Kumwe\Automation\JobExecutionClass` | enum | `cases()`, `from()`, `tryFrom()` |
| `Kumwe\Automation\JobHandler` | interface | `handle()`, `type()` |
| `Kumwe\Automation\JobHandlerRegistry` | class | `__construct()`, `find()`, `types()` |
| `Kumwe\Automation\JobLease` | class | `__construct()`, `acquiredAt()`, `assertActiveOwner()`, `expiresAt()`, `isExpiredAt()`, `owner()`, `renew()` |
| `Kumwe\Automation\JobQueue` | interface | `all()`, `cancel()`, `claim()`, `complete()`, `disconnect()`, `enqueue()`, `fail()`, `heartbeat()`, `renew()`, `retry()` |
| `Kumwe\Automation\JobStatus` | enum | `cases()`, `from()`, `tryFrom()` |
| `Kumwe\Automation\PermanentFailure` | class |  |
| `Kumwe\Automation\QueueContributionDefinition` | class | `__construct()`, `fromArray()`, `identifier()`, `leaseSeconds()`, `maximumAttempts()`, `maximumInFlight()`, `retentionDays()`, `toArray()` |
| `Kumwe\Automation\QueueRuntimePolicy` | class | `__construct()`, `toArray()` |
| `Kumwe\Automation\QueueRuntimePolicyCatalog` | interface | `maximumAttempts()`, `policies()`, `policy()` |
| `Kumwe\Automation\RetryDecision` | class | `__construct()` |
| `Kumwe\Automation\RetryPolicy` | class | `__construct()`, `classify()`, `decide()` |
| `Kumwe\Automation\ScheduleContributionDefinition` | class | `__construct()`, `cronExpression()`, `enabled()`, `fromArray()`, `identifier()`, `jobType()`, `payload()`, `queue()`, `siteIdentifier()`, `timezone()`, `toArray()` |
| `Kumwe\Automation\StoredJob` | class | `__construct()` |
| `Kumwe\Automation\TransientFailure` | interface |  |
