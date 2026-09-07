# Public API

Generated from the package's canonical PHP types and method contracts. Runtime services are composed explicitly with ConfigProvider; value objects are constructed directly. No package service captures host authorization, tenant or transaction state.

## `Kumwe\Automation\AutomationNotFound`

Signals that the schedule the caller named is not there to be acted on.

`AutomationManagementService` raises it where the repository's lookup comes back null, which is the
one case that means genuinely absent: a schedule the actor may not manage is found and then refused
by the repository, so that outcome surfaces as `AuthorizationDenied` and never arrives here.
`AutomationApiHandler` renders this as a 404 problem document, and the message stays operator-facing
rather than repeating the identifier that was asked for.

@since  2.0.0


## `Kumwe\Automation\ConfigProvider`

Deterministic optional Laminas/Mezzio wiring for portable automation services. */


### `__invoke`

```php
__invoke(): array
```

Return package services and safe defaults; the host must supply its ClockInterface.
@return array<string, mixed> Shared services, aliases and kumwe.automation options.

## `Kumwe\Automation\Container\CryptographicJitterSourceFactory`

Constructs the stateless secure jitter dependency without drawing randomness during wiring. */


### `__invoke`

```php
__invoke(Psr\Container\ContainerInterface $container): Kumwe\Automation\CryptographicJitterSource
```

@param ContainerInterface $container Host composition container, never retained.
@return CryptographicJitterSource Shared stateless jitter source.

## `Kumwe\Automation\Container\JobHandlerRegistryFactory`

Resolves the host's explicit handler service list without discovery or trust decisions. */


### `__invoke`

```php
__invoke(Psr\Container\ContainerInterface $container): Kumwe\Automation\JobHandlerRegistry
```

@param ContainerInterface $container Supplies config and explicitly declared handler services.
@return JobHandlerRegistry Shared registry; duplicate types are rejected by its constructor.
@throws InvalidArgumentException On malformed service identifiers or non-handler services.

## `Kumwe\Automation\Container\RetryPolicyFactory`

Constructs the shared policy from explicit clock, jitter and validated delay settings. */


### `__invoke`

```php
__invoke(Psr\Container\ContainerInterface $container): Kumwe\Automation\RetryPolicy
```

@param ContainerInterface $container Supplies config, ClockInterface and JitterSource.
@return RetryPolicy Shared policy without operation or tenant state.
@throws InvalidArgumentException On malformed options or incorrectly typed dependencies.

## `Kumwe\Automation\CronExpression`

Five-field cron expression parsed once and asked for the instants a schedule fires on.

The automation adapters build one when a schedule is created, so an unusable expression is rejected
before it reaches the database, and builds it again at dispatch to advance `next_run_at`. Each
field accepts `*`, a single value, a range, a comma-separated list, and a `/step` suffix, and a
day-of-week seven is folded onto zero so both spellings of Sunday work. The two calendar fields
follow the traditional cron rule: when day-of-month and day-of-week are both restricted, either
one matching is enough, and when either is a bare `*` both have to match.

@since  2.0.0


### `__construct`

```php
__construct(string $expression)
```

Parse an expression into the per-field match sets used for every later lookup.

@param   string  $expression  Five whitespace-separated fields: minute, hour, day of month, month, weekday.

@throws  InvalidArgumentException  When the expression does not hold exactly five fields, when a field
         is malformed, or when a value falls outside the field's range.

@since   2.0.0

### `next`

```php
next(DateTimeImmutable $after, string $timezone): DateTimeImmutable
```

Find the first instant strictly after a given time that the expression fires on.

Matching happens in the schedule's own timezone, so an expression pinned to a wall-clock hour keeps
that hour across a daylight-saving shift; the answer is converted to UTC for storage. The search
starts at the following whole minute with seconds cleared, and walks forward a minute at a time.

@param   DateTimeImmutable  $after     Instant the search starts from, exclusive.
@param   string             $timezone  IANA identifier the expression's fields are read in.

@return  DateTimeImmutable  The next matching minute, expressed in UTC.

@throws  \DateInvalidTimeZoneException  When the timezone is not a known identifier.
@throws  RuntimeException  When no minute within the next five years matches, which means
         the expression names an impossible date such as 30 February.

@since   2.0.0

### `__toString`

```php
__toString(): string
```

Render the expression back to the exact text it was constructed from.

@return  string  The original expression, unnormalised, so a stored schedule round-trips unchanged.

@since   2.0.0

## `Kumwe\Automation\CryptographicJitterSource`

Supplies unbiased operating-system randomness for production retry backoff.

@since  2.0.0


### `between`

```php
between(int $minimum, int $maximum): int
```

Generate a cryptographically secure integer within the inclusive bounds.

@param   int  $minimum  Inclusive lower bound accepted for the value.
@param   int  $maximum  Inclusive upper bound accepted for the value.

@return  int  Cryptographically sampled integer inside the inclusive bounds.

@since   2.0.0

## `Kumwe\Automation\ExpiredJobLease`

Failure recorded for a job whose final worker lease expired before the job completed.

A worker that dies mid-job never reports; what the queue can observe is that the lease it granted has
run out while the job is still marked running. When that happens on the last permitted attempt the
queue buries the job itself, and the failed-job row it writes names this type as the failure, so an
operator reading the dead-letter screen sees the same vocabulary a handler-raised failure carries
instead of a label that resolves to nothing. Nothing in the process throws it today — the queue detects
the condition after the fact — but a worker that discovers its own lease has lapsed may raise it to say
why it abandoned the work.

@since  2.0.0


## `Kumwe\Automation\FailureClassification`

Verdict on whether a failed job may be attempted again.

`RetryPolicy` derives this from the thrown value and carries it on the `RetryDecision` it returns,
so whoever schedules the next attempt can tell a fault that will clear from one that will repeat
for the same payload. `PermanentFailure`, `LogicException` and `Error` are permanent; anything the
policy does not recognise is transient, because retrying costs less than discarding work over a
fault the policy has not been taught about yet.

@since  2.0.0

- Constant `TRANSIENT`
- Constant `PERMANENT`
- Property `string $name` (readonly)
- Property `string $value` (readonly)

### `cases`

```php
static cases(): array
```



### `from`

```php
static from(string|int $value): static
```



### `tryFrom`

```php
static tryFrom(string|int $value): ?static
```



## `Kumwe\Automation\JitterSource`

Supplier of the random number a retry delay is drawn from.

`RetryPolicy` computes how wide the backoff window is for an attempt and then asks this port for a
value inside it, instead of calling `random_int()` itself. That indirection is what makes the policy
testable: a test substitutes a source that always answers the same number and can then assert the
exact delay and the exact instant a retry falls due. The policy does not trust the answer — it
re-checks the returned value against the range it asked for and refuses one that falls outside — so
an implementation cannot lengthen or cancel a backoff by answering out of bounds.

@since  2.0.0


### `between`

```php
between(int $minimum, int $maximum): int
```

Draw one value from the inclusive range the caller offers.

@param   int  $minimum  Lowest value the caller is prepared to accept.
@param   int  $maximum  Highest value the caller is prepared to accept; callers never pass a bound
         below the minimum.

@return  int  A value between the two bounds, both included; the caller may re-check it.

@since   2.0.0

## `Kumwe\Automation\JobContributionDefinition`

Declarative job handler and payload contract for trusted runtime compilation.

@since  0.2.0


### `__construct`

```php
__construct(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, string $jobType, int $schemaVersion, string $handlerVersion, array $payloadSchema, string $queue = 'default', int $maximumAttempts = 5, bool $installationWide = false)
```

Define one contributed job type.

@param   string                $jobType           Namespaced job type.
@param   int                   $schemaVersion     Payload schema revision.
@param   string                $handlerVersion    Executable handler revision.
@param   array<string, mixed>  $payloadSchema     Declarative JSON Schema subset.
@param   string                $queue             Default queue.
@param   int                   $maximumAttempts   Default retry budget.
@param   bool                  $installationWide  Whether work is installation rather than site scoped.

@throws  InvalidArgumentException  When a declaration value is invalid.

@since   0.2.0

### `identifier`

```php
identifier(): string
```

Return the stable identifier for the job contribution definition.

@return  string  Job type.

@since   0.2.0

### `schemaVersion`

```php
schemaVersion(): int
```

Return the event payload schema version.

@return  int  Payload schema revision.

@since   0.2.0

### `handlerVersion`

```php
handlerVersion(): string
```

Return the handler implementation version used for compatibility checks.

@return  string  Executable handler revision.

@since   0.2.0

### `payloadSchema`

```php
payloadSchema(): array
```

Return the bounded JSON schema governing the payload.

@return  array<string, mixed>  Declarative payload schema.

@since   0.2.0

### `queue`

```php
queue(): string
```

Return the declared durable queue identifier.

@return  string  Default logical queue.

@since   0.2.0

### `maximumAttempts`

```php
maximumAttempts(): int
```

Return the maximum number of delivery attempts.

@return  int  Retry attempt budget.

@since   0.2.0

### `installationWide`

```php
installationWide(): bool
```

Return the installation wide carried by this job contribution definition.

@return  bool  Whether the handler executes outside a site scope.

@since   0.2.0

### `toArray`

```php
toArray(): array
```

Serialize the job contribution definition for durable storage or inspection.

@return  array<string, mixed>  Canonical publication representation.

@since   0.2.0

### `fromArray`

```php
static fromArray(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, array $data): Kumwe\Automation\JobContributionDefinition
```

Parse the closed manifest representation of a job contribution.

@param   array<string, mixed>  $data  Manifest contribution object.

@return  self  Validated job definition.

@since   0.2.0

## `Kumwe\Automation\JobDeclaration`

Immutable typed view of one validated manifest job declaration. @since 0.2.0 */


### `fromManifest`

```php
static fromManifest(array $data): Kumwe\Automation\JobDeclaration
```

@param array<string, mixed> $data @since 0.2.0 */

### `type`

```php
type(): string
```

@since 0.2.0 */

### `schemaVersion`

```php
schemaVersion(): int
```

@since 0.2.0 */

### `toArray`

```php
toArray(): array
```

@return array<string, mixed> @since 0.2.0 */

## `Kumwe\Automation\JobEnvelope`

Immutable state machine for one queued job, from creation through claim to completion or death.

Every transition returns a fresh envelope through the private constructor, which re-runs the whole
invariant set, so combinations that must never exist — a reserved job without a lease, more attempts
than the maximum, availability before creation — cannot be represented at all. Worker-driven
transitions go through the lease first, which is what stops two workers from finishing the same job,
and the payload is proven canonically encodable at construction rather than at storage time.

@since  2.0.0


### `pending`

```php
static pending(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, string $id, string $queue, string $type, array $payload, DateTimeImmutable $availableAt, DateTimeImmutable $createdAt, int $schemaVersion = 1, int $priority = 0, int $maximumAttempts = 5): Kumwe\Automation\JobEnvelope
```

Create a freshly enqueued job: pending, unclaimed, with no attempts spent.

@param   string                $id               Canonical UUID to identify the job by.
@param   string                $queue            Name of the queue the job waits on.
@param   string                $type             Registered job type deciding which handler runs it.
@param   array<string, mixed>  $payload          Job arguments; must be canonical-JSON encodable.
@param   DateTimeImmutable     $availableAt      Earliest claim moment; not before creation.
@param   DateTimeImmutable     $createdAt        Moment the job is enqueued.
@param   int                   $schemaVersion    Version of the payload contract, from one upwards.
@param   int                   $priority         Relative claim-order weight, between -100 and 100.
@param   int                   $maximumAttempts  Claims allowed before the job is declared dead.

@return  self  A pending envelope with no lease and zero attempts.

@throws  InvalidArgumentException  When an argument violates a job invariant.

@since   2.0.0

### `id`

```php
id(): string
```

Identify the job.

@return  string  Canonical UUID, carried unchanged through every transition.

@since   2.0.0

### `queue`

```php
queue(): string
```

Name the queue the job waits on.

@return  string  Queue name a worker must be polling for this job to be claimed.

@since   2.0.0

### `type`

```php
type(): string
```

Name the registered type that decides which handler executes the job.

@return  string  Job type resolved against the handler registry at execution time.

@since   2.0.0

### `payload`

```php
payload(): array
```

Return the arguments handed to the handler.

@return  array<string, mixed>  Payload as enqueued, to be read under the recorded schema version.

@since   2.0.0

### `schemaVersion`

```php
schemaVersion(): int
```

Report which version of the payload contract the job was enqueued under.

@return  int  Schema version, one or greater, letting a handler still read older jobs.

@since   2.0.0

### `priority`

```php
priority(): int
```

Report the weight a queue uses to order this job against its peers.

@return  int  Between -100 and 100; higher means the job is meant to be claimed sooner.

@since   2.0.0

### `status`

```php
status(): Kumwe\Automation\JobStatus
```

Report where the job stands in its lifecycle.

@return  JobStatus  Current state; only a reserved job carries a lease.

@since   2.0.0

### `attempts`

```php
attempts(): int
```

Report how many times the job has been claimed.

@return  int  Attempts spent; the count rises at claim time, not at completion.

@since   2.0.0

### `maximumAttempts`

```php
maximumAttempts(): int
```

Report the attempt budget the job is allowed.

@return  int  Claims permitted in total; once spent, the next release buries the job.

@since   2.0.0

### `availableAt`

```php
availableAt(): DateTimeImmutable
```

Report the earliest moment the job may be claimed.

@return  DateTimeImmutable  Availability instant, moved forward whenever a retry is scheduled.

@since   2.0.0

### `lease`

```php
lease(): ?Kumwe\Automation\JobLease
```

Return the hold a worker currently has on the job.

@return  ?JobLease  The live hold while reserved; null in every other state.

@since   2.0.0

### `createdAt`

```php
createdAt(): DateTimeImmutable
```

Report when the job was enqueued.

@return  DateTimeImmutable  Creation instant, never later than the availability instant.

@since   2.0.0

### `isClaimableAt`

```php
isClaimableAt(DateTimeImmutable $time): bool
```

Decide whether a worker may claim this job at a given moment.

@param   DateTimeImmutable  $time  Moment to test, normally the claiming worker's clock reading.

@return  bool  True only while pending, already available, and still inside the attempt budget.

@since   2.0.0

### `claim`

```php
claim(string $worker, DateTimeImmutable $time, int $leaseSeconds): Kumwe\Automation\JobEnvelope
```

Reserve the job for a worker and start its lease.

The attempt is spent here rather than at completion, so a worker that dies without releasing has
already used one up; reaping its expired lease does not hand it back.

@param   string             $worker        Identifier of the worker taking the job.
@param   DateTimeImmutable  $time          Moment of the claim, from which the lease runs.
@param   int                $leaseSeconds  Length of the initial hold in seconds; at least one.

@return  self  A reserved envelope carrying a fresh lease and one more spent attempt.

@throws  InvalidArgumentException  When the hold is under a second, or the worker identifier is invalid.
@throws  DomainException  When the job is not claimable at that moment.

@since   2.0.0

### `releaseExpiredLease`

```php
releaseExpiredLease(DateTimeImmutable $time): Kumwe\Automation\JobEnvelope
```

Reap a job whose lease ran out, putting it back in the queue or burying it.

This is the recovery path rather than the worker path, so it deliberately asks for no owner: the
whole point is to reclaim a job from a worker that is no longer there. The job becomes available
again from the reaping moment unless its attempt budget is already spent.

@param   DateTimeImmutable  $time  Moment of the reap, which becomes the new availability instant.

@return  self  A pending envelope with no lease, or a dead one when no attempts remain.

@throws  DomainException  When the job is not reserved, or its lease has not expired yet.

@since   2.0.0

### `releaseForRetry`

```php
releaseForRetry(string $worker, DateTimeImmutable $time, DateTimeImmutable $retryAt): Kumwe\Automation\JobEnvelope
```

Hand a failed attempt back to the queue for a later retry, or bury it when the budget is spent.

@param   string             $worker   Worker giving the job up; must still hold an active lease.
@param   DateTimeImmutable  $time     Moment of the release.
@param   DateTimeImmutable  $retryAt  Moment the job becomes claimable again; not before `$time`.

@return  self  A pending envelope available from the retry instant, or a dead one when attempts ran out.

@throws  DomainException  When the job is not reserved, or the worker's lease is not active.
@throws  InvalidArgumentException  When the retry is scheduled before the release moment.

@since   2.0.0

### `complete`

```php
complete(string $worker, DateTimeImmutable $time): Kumwe\Automation\JobEnvelope
```

Record the job as finished by the worker holding its lease.

@param   string             $worker  Worker reporting success; must hold an active lease.
@param   DateTimeImmutable  $time    Moment success is reported, used to test lease expiry.

@return  self  A completed envelope with its lease released.

@throws  DomainException  When the job is not reserved, or the worker's lease is not active.

@since   2.0.0

### `renewLease`

```php
renewLease(string $worker, DateTimeImmutable $time, int $leaseSeconds): Kumwe\Automation\JobEnvelope
```

Extend the current hold so a still-working worker is not reaped mid-job.

The job stays reserved, its availability instant and attempt count untouched; only the lease
expiry moves, and only for the worker that already owns it.

@param   string             $worker        Worker asking to keep the job; must own the lease.
@param   DateTimeImmutable  $time          Moment of the request, from which the new window runs.
@param   int                $leaseSeconds  Length of the new window in seconds; at least one.

@return  self  A reserved envelope whose lease expires later.

@throws  DomainException  When the job is not reserved, or the worker's lease is not active.
@throws  InvalidArgumentException  When fewer than one second of hold is requested.

@since   2.0.0

## `Kumwe\Automation\JobExecutionClass`

Blast radius of a job type: whether its effect belongs to one site or to the whole installation.

`JobExecutionScope` derives the class from the job type, and the queue and scheduler persist it on
every schedule and job row. It then decides three things on the way back out: which principal the
worker builds the job's execution context from, whether the claim query insists on a live enabled
owner site, and which resource an `automation.manage` decision is made against.

@since  2.0.0

- Constant `Site`
- Constant `Installation`
- Property `string $name` (readonly)
- Property `string $value` (readonly)

### `cases`

```php
static cases(): array
```



### `from`

```php
static from(string|int $value): static
```



### `tryFrom`

```php
static tryFrom(string|int $value): ?static
```



## `Kumwe\Automation\JobHandler`

Contract for the unit of work behind one queued job type.

The worker resolves a claimed job's handler by type through `JobHandlerRegistry` and calls it with
the decoded payload and a context already narrowed to the job's owner — the owning site's system
principal, or the internal identity an installation-global type is pinned to. An implementation must
be safe to run more than once, because a process can die after an external side effect but before
completion is recorded, and the job then becomes claimable again. Throwing `PermanentFailure` buries
the job immediately; any other exception is transient, so the job is retried with backoff until its
attempts run out. Work that legitimately outlives its lease implements `LeaseAwareJobHandler`.

@since  2.0.0


### `type`

```php
type(): string
```

Name the job type this handler executes.

@return  string  Registered type name, unique across every handler wired into the registry.

@since   2.0.0

### `handle`

```php
handle(array $payload, Kumwe\Context\Value\ExecutionContext $context): void
```

Execute one claimed job of this handler's type.

@param   array<string, mixed>  $payload  Decoded job arguments, in the shape the type's schema declares.
@param   ExecutionContext      $context  Authorization context the worker built for the job's owner.

@return  void

@since   2.0.0

## `Kumwe\Automation\JobHandlerRegistry`

Type-indexed lookup of every job handler wired into the container.

The worker resolves a claimed job's handler here, and the automation management service reads the
registered types to decide what an operator may schedule. Indexing happens once at construction, so
two handlers claiming the same type are rejected while the container is being built rather than at
the moment such a job is first executed.

@since  2.0.0


### `__construct`

```php
__construct(iterable $handlers)
```

Index the wired handlers by the type each claims.

@param   iterable<JobHandler>  $handlers  Handlers to register, in container wiring order.

@throws  InvalidArgumentException  When two handlers claim the same job type.

@since   2.0.0

### `find`

```php
find(string $type): ?Kumwe\Automation\JobHandler
```

Look up the handler registered for a job type.

@param   string  $type  Job type read from the claimed queue row.

@return  ?JobHandler  Null when nothing claims the type, which the worker fails permanently.

@since   2.0.0

### `types`

```php
types(): array
```

List every registered job type in a stable order.

@return  list<string>  Type names sorted as strings, so callers can present them predictably.

@since   2.0.0

## `Kumwe\Automation\JobLease`

Time-boxed, owner-bound hold a worker has on a reserved job.

The lease is what entitles one worker, and only that worker, to complete, retry, or extend the job
it claimed: `JobEnvelope` routes each of those transitions through the ownership and expiry checks
here first. Expiry is wall-clock, so a worker that dies mid-job gives up its hold without having to
cooperate, and the owner comparison uses `hash_equals` so the check does not leak by timing.

@since  2.0.0


### `__construct`

```php
__construct(string $owner, DateTimeImmutable $acquiredAt, DateTimeImmutable $expiresAt)
```

Record a worker's hold on a job for a bounded window.

@param   string             $owner       Identifier of the worker taking the job.
@param   DateTimeImmutable  $acquiredAt  Moment the hold began.
@param   DateTimeImmutable  $expiresAt   Moment the hold lapses; must be later than acquisition.

@throws  InvalidArgumentException  When the owner is not a valid worker identifier, or the window is empty.

@since   2.0.0

### `owner`

```php
owner(): string
```

Identify the worker entitled to act on the leased job.

@return  string  Worker identifier recorded when the hold was taken.

@since   2.0.0

### `acquiredAt`

```php
acquiredAt(): DateTimeImmutable
```

Report when the hold began.

@return  DateTimeImmutable  Instant of the original claim, carried unchanged through renewals.

@since   2.0.0

### `expiresAt`

```php
expiresAt(): DateTimeImmutable
```

Report when the hold lapses.

@return  DateTimeImmutable  Instant from which the job may be reaped from this worker.

@since   2.0.0

### `isExpiredAt`

```php
isExpiredAt(DateTimeImmutable $time): bool
```

Decide whether the hold has lapsed at a given moment.

@param   DateTimeImmutable  $time  Moment to test, normally the caller's current clock reading.

@return  bool  True from the expiry instant onwards; the expiry moment itself already counts as expired.

@since   2.0.0

### `assertActiveOwner`

```php
assertActiveOwner(string $owner, DateTimeImmutable $time): void
```

Prove that a worker still holds this lease before it is allowed to act on the job.

@param   string             $owner  Worker claiming the hold.
@param   DateTimeImmutable  $time   Moment the action is attempted.

@return  void

@throws  DomainException  When the worker is not the owner, or the hold has already lapsed.

@since   2.0.0

### `renew`

```php
renew(string $owner, DateTimeImmutable $time, int $leaseSeconds): Kumwe\Automation\JobLease
```

Extend an active hold, measured from the renewal moment rather than from the current expiry.

@param   string             $owner         Worker asking to keep the job; must be the current owner.
@param   DateTimeImmutable  $time          Moment of the request, from which the new window runs.
@param   int                $leaseSeconds  Length of the new window in seconds; at least one.

@return  self  A lease with the original acquisition instant and the later expiry.

@throws  InvalidArgumentException  When fewer than one second of hold is requested.
@throws  DomainException  When the caller is not the owner, or the hold has already lapsed.

@since   2.0.0

## `Kumwe\Automation\JobQueue`

Contract for the durable store a queued job lives in, from enqueue through claim to completion.

Producers hand work over with `enqueue()` and never touch it again, workers take one job at a time
with `claim()` and settle it with `complete()` or `fail()`, and operators read the backlog with
`all()` before pushing individual jobs around with `retry()` and `cancel()`. Every call carries the
caller's `ExecutionContext`, so the store rather than the caller decides who may do which of those.

The claim is fenced. `claim()` stamps a fresh token onto the `StoredJob` it hands back, and `renew()`,
`complete()` and `fail()` only take effect while the calling worker still presents that token, so a
worker whose lease expired and whose job was re-claimed elsewhere cannot record an outcome over the
top of the worker that now owns it.

@since  2.0.0


### `enqueue`

```php
enqueue(Kumwe\Context\Value\ExecutionContext $context, string $type, array $payload, DateTimeImmutable $availableAt, string $queue = 'default', int $priority = 0, int $maximumAttempts = 5): string
```

Store a new job for a worker to pick up later.

@param   ExecutionContext      $context          Actor and site the job is produced under.
@param   string                $type             Registered job type deciding which handler runs it.
@param   array<string, mixed>  $payload          Job arguments, in the shape the type's schema declares.
@param   DateTimeImmutable     $availableAt      Earliest moment a worker may claim the job.
@param   string                $queue            Name of the queue workers poll for this job.
@param   int                   $priority         Claim-order weight; higher is claimed first.
@param   int                   $maximumAttempts  Claims allowed before the job is declared dead.

@return  string  Identifier of the stored job, as passed to `retry()` and `cancel()`.

@since   2.0.0

### `claim`

```php
claim(Kumwe\Context\Value\ExecutionContext $context, string $queue, string $workerId, int $leaseSeconds): ?Kumwe\Automation\StoredJob
```

Take the next runnable job on a queue under a time-boxed, fenced lease.

@param   ExecutionContext  $context       Actor and site the worker runs as.
@param   string            $queue         Name of the queue to take work from.
@param   string            $workerId      Identity recorded as the holder of the lease.
@param   int               $leaseSeconds  How long the claim holds before another worker may take over.

@return  ?StoredJob  The job with a fresh fencing token, or null when the queue holds nothing this
         worker may run.

@since   2.0.0

### `renew`

```php
renew(Kumwe\Context\Value\ExecutionContext $context, Kumwe\Automation\StoredJob $job, string $workerId, int $leaseSeconds): void
```

Renew an active lease without changing its fencing token.

The expiry moves out from now, so a handler renewing at safe checkpoints stays out of reach of the
reaper without ever surrendering the token its later `complete()` or `fail()` depends on.

@param   ExecutionContext  $context       Actor and site the worker runs as.
@param   StoredJob         $job           Job whose lease is extended; carries the token proving it.
@param   string            $workerId      Identity that must still hold the lease.
@param   int               $leaseSeconds  Length of the new window, measured from now.

@return  void

@since   2.0.0

### `complete`

```php
complete(Kumwe\Context\Value\ExecutionContext $context, Kumwe\Automation\StoredJob $job, string $workerId): void
```

Record a successful attempt and take the job out of circulation for good.

@param   ExecutionContext  $context   Actor and site the worker runs as.
@param   StoredJob         $job       Job that finished; carries the token proving the lease.
@param   string            $workerId  Identity that must still hold the lease.

@return  void

@since   2.0.0

### `fail`

```php
fail(Kumwe\Context\Value\ExecutionContext $context, Kumwe\Automation\StoredJob $job, string $workerId, Throwable $failure, bool $permanent): void
```

Record a failed attempt, either leaving the job to run again or burying it.

@param   ExecutionContext  $context    Actor and site the worker runs as.
@param   StoredJob         $job        Job whose attempt failed; carries the token proving the lease.
@param   string            $workerId   Identity that must still hold the lease.
@param   Throwable         $failure    Value that ended the attempt, kept for the operator record.
@param   bool              $permanent  True to bury the job now, whatever attempts remain.

@return  void

@since   2.0.0

### `heartbeat`

```php
heartbeat(Kumwe\Context\Value\ExecutionContext $context, string $workerId, string $queue, ?string $jobId = NULL): void
```

Record that a worker is alive on a queue, and which job it currently holds.

@param   ExecutionContext  $context   Actor and site the worker runs as.
@param   string            $workerId  Identity of the worker reporting in.
@param   string            $queue     Queue the worker is polling.
@param   ?string           $jobId     Job in flight, or null while the worker holds none.

@return  void

@since   2.0.0

### `disconnect`

```php
disconnect(Kumwe\Context\Value\ExecutionContext $context, string $workerId, string $queue): void
```

Retire a worker's liveness record when it stops polling a queue.

Jobs the worker still holds are left alone: their leases simply expire and are reaped on a later
claim, so a worker shutting down never has to settle work it did not finish.

@param   ExecutionContext  $context   Actor and site the worker runs as.
@param   string            $workerId  Identity of the worker leaving.
@param   string            $queue     Queue it was polling.

@return  void

@since   2.0.0

### `all`

```php
all(Kumwe\Context\Value\ExecutionContext $context, int $limit = 100): array
```

List recent jobs for an operator view, whatever state they are in.

@param   ExecutionContext  $context  Actor and site the listing is filtered for.
@param   int               $limit    Largest number of rows to hand back.

@return  list<array<string, mixed>>  Job rows this caller may manage, newest created first.

@since   2.0.0

### `retry`

```php
retry(Kumwe\Context\Value\ExecutionContext $context, string $id): void
```

Return a buried job to the queue for a fresh run.

Only a job that has died is retryable, and it comes back with its attempt counter reset, so the new
run gets a full budget instead of dying again on its first failure.

@param   ExecutionContext  $context  Actor and site the operator acts as.
@param   string            $id       Identifier of the dead job to requeue.

@return  void

@since   2.0.0

### `cancel`

```php
cancel(Kumwe\Context\Value\ExecutionContext $context, string $id): void
```

Withdraw a job no worker has claimed yet.

Only a pending job can be canceled; once a worker holds the lease the job must be left to finish or
fail, because the queue has no way to interrupt a running handler.

@param   ExecutionContext  $context  Actor and site the operator acts as.
@param   string            $id       Identifier of the pending job to withdraw.

@return  void

@since   2.0.0

## `Kumwe\Automation\JobStatus`

Lifecycle state of a queued job, as recorded in the status column of the jobs table.

`JobEnvelope` is the state machine that moves a job between these values and rejects the combinations
that must not exist, while a `JobQueue` implementation writes and reads the backing strings. Only
`PENDING` and `RESERVED` are working states, and a job cycles between them for as long as it keeps
failing transiently; the other three are where it comes to rest, and nothing but an operator retry
moves a job back out of `DEAD`.

@since  2.0.0

- Constant `PENDING`
- Constant `RESERVED`
- Constant `COMPLETED`
- Constant `DEAD`
- Constant `CANCELED`
- Property `string $name` (readonly)
- Property `string $value` (readonly)

### `cases`

```php
static cases(): array
```



### `from`

```php
static from(string|int $value): static
```



### `tryFrom`

```php
static tryFrom(string|int $value): ?static
```



## `Kumwe\Automation\PermanentFailure`

Failure a job handler raises to say the work must not be attempted again.

`Worker` catches whatever the handler throws and passes `instanceof PermanentFailure` to the queue as
the permanence flag, so a job raising this is buried at once instead of being backed off through the
attempts it has left; `RetryPolicy` classifies it the same way. Reach for it when the payload itself is
the fault — a missing field, a record that no longer exists — because an identical retry would fail
identically and only delay the operator seeing it. The worker raises it itself when a claimed job's
type has no registered handler.

@since  2.0.0


## `Kumwe\Automation\QueueContributionDefinition`

Bounded logical queue declaration for extension jobs and event deliveries.

@since  2.0.0


### `__construct`

```php
__construct(string $queueId, int $leaseSeconds = 60, int $maximumAttempts = 10, int $maximumInFlight = 16, int $retentionDays = 30)
```

Describe one queue's portable processing limits.

@param   string  $queueId          Namespaced logical queue identifier.
@param   int     $leaseSeconds     Claim lease, between 5 seconds and one hour.
@param   int     $maximumAttempts  Default delivery attempt budget.
@param   int     $maximumInFlight  Durable cross-process live-claim ceiling.
@param   int     $retentionDays    Completed/dead evidence retention.

@throws  InvalidArgumentException  When a queue limit is outside its portable bound.

@since   2.0.0

### `identifier`

```php
identifier(): string
```

Return the stable identifier for the queue contribution definition.

@return  string  Namespaced queue identity.

@since   2.0.0

### `leaseSeconds`

```php
leaseSeconds(): int
```

Return the duration of each worker lease in seconds.

@return  int  Claim lease in seconds.

@since   2.0.0

### `maximumAttempts`

```php
maximumAttempts(): int
```

Return the maximum number of delivery attempts.

@return  int  Default attempt budget.

@since   2.0.0

### `maximumInFlight`

```php
maximumInFlight(): int
```

Return the queue concurrency ceiling.

@return  int  Durable cross-process live-claim ceiling.

@since   2.0.0

### `retentionDays`

```php
retentionDays(): int
```

Return the number of days completed queue records are retained.

@return  int  Evidence retention in days.

@since   2.0.0

### `toArray`

```php
toArray(): array
```

Serialize the queue contribution definition for durable storage or inspection.

@return  array<string, mixed>  Canonical publication representation.

@since   2.0.0

### `fromArray`

```php
static fromArray(array $data): Kumwe\Automation\QueueContributionDefinition
```

Reconstitute the queue contribution definition from validated array data.

@param   array<string, mixed>  $data  Validated contribution data from which the named member is read.

@return  self  Validated queue declaration.

@since   2.0.0

## `Kumwe\Automation\QueueRuntimePolicy`

Trusted executable limits for one contributed durable queue.

The contribution layer compiles signed queue declarations into this delivery-neutral value. Queue
producers, schedulers, workers and operator tooling then consume the same limits, so inventory cannot
drift away from the runtime behavior it describes.

@since  2.0.0

- Property `string $queue` (readonly)
- Property `int $leaseSeconds` (readonly)
- Property `int $maximumAttempts` (readonly)
- Property `int $maximumInFlight` (readonly)
- Property `int $retentionDays` (readonly)
- Property `int $runtimeGeneration` (readonly)

### `__construct`

```php
__construct(string $queue, int $leaseSeconds, int $maximumAttempts, int $maximumInFlight, int $retentionDays, int $runtimeGeneration)
```

Capture one active queue policy and the trusted runtime generation that supplied it.

@param   string  $queue              Namespaced logical queue identifier.
@param   int     $leaseSeconds       Longest permitted claim or renewal lease.
@param   int     $maximumAttempts    Queue-wide delivery-attempt ceiling.
@param   int     $maximumInFlight    Durable cross-process in-flight ceiling.
@param   int     $retentionDays      Terminal job deletion and delivery-detail compaction retention.
@param   int     $runtimeGeneration  Trusted extension runtime generation.

@throws  InvalidArgumentException  When a value falls outside the portable contribution bounds.

@since   2.0.0

### `toArray`

```php
toArray(): array
```

Export the policy for authenticated operator surfaces.

@return  array{
             queue: string,
             lease_seconds: int,
             maximum_attempts: int,
             maximum_in_flight: int,
             retention_days: int,
             runtime_generation: int
         } Canonical policy document.

@since   2.0.0

## `Kumwe\Automation\QueueRuntimePolicyCatalog`

Read side of the active trusted queue and contributed-job policy graph.

Core queues deliberately return no policy and retain the established queue defaults. A contributed
queue returns its signed limits, while `maximumAttempts()` also folds in a contributed job handler's
own attempt ceiling. Producers and scheduler dispatch therefore cannot persist a budget wider than
either active declaration.

@since  2.0.0


### `policy`

```php
policy(string $queue): ?Kumwe\Automation\QueueRuntimePolicy
```

Resolve one active contributed queue.

@param   string  $queue  Logical queue identifier.

@return  ?QueueRuntimePolicy  Active trusted policy, or null for an undeclared core queue.

@since   2.0.0

### `maximumAttempts`

```php
maximumAttempts(string $queue, string $jobType, int $requested): int
```

Narrow a requested attempt budget through the active job-handler and queue declarations.

@param   string  $queue      Destination queue.
@param   string  $jobType    Registered handler type.
@param   int     $requested  Producer or schedule attempt budget.

@return  int  Budget no wider than the request, contributed handler, or contributed queue.

@since   2.0.0

### `policies`

```php
policies(): array
```

List active contributed queue policies in deterministic queue order.

@return  list<QueueRuntimePolicy>  Trusted active queue policies.

@since   2.0.0

## `Kumwe\Automation\RetryDecision`

Verdict `RetryPolicy` reaches about one failed attempt: whether to run it again, and when.

Whoever settles the job reads this instead of re-deriving anything — the classification explains the
verdict, and the delay and instant describe the next attempt. When `shouldRetry` is false the two
scheduling fields are inert, the delay zero and the instant null, so a caller burying a job can act on
this value without first testing which fields still mean something.

@since  2.0.0

- Property `Kumwe\Automation\FailureClassification $classification` (readonly)
- Property `bool $shouldRetry` (readonly)
- Property `int $delaySeconds` (readonly)
- Property `?DateTimeImmutable $retryAt` (readonly)

### `__construct`

```php
__construct(Kumwe\Automation\FailureClassification $classification, bool $shouldRetry, int $delaySeconds, ?DateTimeImmutable $retryAt)
```

Capture what the policy concluded about one failed attempt.

@param  FailureClassification  $classification  Whether the fault should clear or will repeat.
@param  bool                   $shouldRetry     True when the fault is transient and attempts remain.
@param  int                    $delaySeconds    Backoff before the next attempt; zero when none follows.
@param  ?DateTimeImmutable     $retryAt         Instant the next attempt is due, or null when none is.

@since  2.0.0

## `Kumwe\Automation\RetryPolicy`

Decides whether a failed job attempt is worth repeating, and how long to wait before repeating it.

The policy keeps apart two questions a caller would otherwise blur: whether the fault can clear at all,
and how hard to back off if it can. The first is answered from the shape of the thrown value, so a
handler signals intent by what it throws rather than by a status it returns. The second is full jitter
— a delay drawn uniformly between zero and a cap that doubles each attempt — which scatters a fleet of
workers retrying the same outage instead of letting them collide on one schedule. Both the randomness
and the clock arrive through the constructor, so the same failure yields the same decision in a test.

@since  2.0.0


### `__construct`

```php
__construct(Psr\Clock\ClockInterface $clock, Kumwe\Automation\JitterSource $jitter, int $baseDelaySeconds = 1, int $maximumDelaySeconds = 300)
```

Configure the backoff window every retry delay is drawn from.

@param   ClockInterface  $clock                Reads the instant a retry becomes due.
@param   JitterSource    $jitter               Randomness the delay is drawn from, injected for tests.
@param   int             $baseDelaySeconds     Jitter cap for the first retry, doubled per attempt after.
@param   int             $maximumDelaySeconds  Ceiling the doubling cap is clamped to.

@throws  InvalidArgumentException  When the base delay is below one second, or the maximum below the base.

@since   2.0.0

### `classify`

```php
classify(Throwable $failure): Kumwe\Automation\FailureClassification
```

Judge whether a thrown value describes a fault that can clear or one that will repeat.

`PermanentFailure`, `LogicException` and `Error` are permanent, because a programming or payload
fault reproduces on identical input. Everything else is transient, including throwables the policy
has never been taught about, since one more attempt costs less than discarding work over an
unfamiliar fault. The `TransientFailure` marker is honoured ahead of the `LogicException` and
`Error` fallback, so an exception in that hierarchy that marks itself transient is still retried.

@param   Throwable  $failure  Value that ended the attempt.

@return  FailureClassification  PERMANENT when a further attempt cannot succeed, TRANSIENT otherwise.

@since   2.0.0

### `decide`

```php
decide(Throwable $failure, int $attempt, int $maximumAttempts): Kumwe\Automation\RetryDecision
```

Turn one failed attempt into the verdict and the moment the next attempt falls due.

A permanent classification, or an attempt that was already the last one allowed, produces a decision
carrying no delay and no instant. Otherwise the delay comes from the jitter source, between zero and
the cap for this attempt, and the due instant is that delay after the clock's current reading. The
jitter source is not trusted blindly: a value outside the range it was handed is rejected rather than
turned into a retry that fires immediately or far too late.

@param   Throwable  $failure          Value that ended the attempt.
@param   int        $attempt          Number of the attempt that just failed, counting from one.
@param   int        $maximumAttempts  Attempts this job is allowed in total.

@return  RetryDecision  The classification, plus the delay and due instant when a retry follows.

@throws  InvalidArgumentException  When either count is below one, or the attempt is past the limit.
@throws  DomainException  When the jitter source returns a value outside the range it was given.

@since   2.0.0

## `Kumwe\Automation\ScheduleContributionDefinition`

Declarative recurring schedule compiled with its owning runtime generation.

@since  2.0.0


### `__construct`

```php
__construct(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, string $scheduleId, string $jobType, string $cronExpression, string $timezone, array $payload, string $queue = 'default', ?string $siteIdentifier = NULL, bool $enabled = true)
```

Define one contributed recurring job.

@param   string                $scheduleId      Namespaced schedule identity.
@param   string                $jobType         Contributed job type.
@param   string                $cronExpression  Five-field cron expression.
@param   string                $timezone        IANA timezone.
@param   array<string, mixed>  $payload         Job arguments.
@param   string                $queue           Destination queue.
@param   ?string               $siteIdentifier  Owning site for site jobs; null for installation jobs.
@param   bool                  $enabled         Initial enabled state.

@throws  InvalidArgumentException  When a declaration value is invalid.

@since   2.0.0

### `identifier`

```php
identifier(): string
```

Return the stable identifier for the schedule contribution definition.

@return  string  Schedule identity.

@since   2.0.0

### `jobType`

```php
jobType(): string
```

Return the job type carried by this schedule contribution definition.

@return  string  Contributed job type.

@since   2.0.0

### `cronExpression`

```php
cronExpression(): string
```

Return the cron expression carried by this schedule contribution definition.

@return  string  Five-field recurrence.

@since   2.0.0

### `timezone`

```php
timezone(): string
```

Return the timezone carried by this schedule contribution definition.

@return  string  IANA timezone.

@since   2.0.0

### `payload`

```php
payload(): array
```

Return the validated payload.

@return  array<string, mixed>  Validated job arguments.

@since   2.0.0

### `queue`

```php
queue(): string
```

Return the declared durable queue identifier.

@return  string  Logical queue.

@since   2.0.0

### `siteIdentifier`

```php
siteIdentifier(): ?string
```

Return the site identifier carried by this schedule contribution definition.

@return  ?string  Explicit site, null only for installation-wide jobs.

@since   2.0.0

### `enabled`

```php
enabled(): bool
```

Return the enabled carried by this schedule contribution definition.

@return  bool  Whether occurrences are initially enabled.

@since   2.0.0

### `toArray`

```php
toArray(): array
```

Serialize the schedule contribution definition for durable storage or inspection.

@return  array<string, mixed>  Canonical publication representation.

@since   2.0.0

### `fromArray`

```php
static fromArray(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, array $data): Kumwe\Automation\ScheduleContributionDefinition
```

Parse the closed manifest representation of a schedule contribution.

@param   array<string, mixed>  $data  Manifest contribution object.

@return  self  Validated schedule definition.

@since   2.0.0

## `Kumwe\Automation\StoredJob`

One reserved queue row, carrying the fencing token that proves the reservation is still this worker's.

`JobQueue::claim()` builds this from the row it reserved and the worker hands the same instance back
to `renew()`, `complete()` and `fail()`. Each of those writes matches on the lease token as well as
the identifier, so a worker whose lease expired and whose job a sibling has re-claimed can no longer
move the row — which is what makes an expired lease safe to reap. Construction rejects a token that
is not a canonical UUID and an execution class that is not a known one, so a row with a missing or
hand-edited lease or scope column never reaches a handler.

@since  2.0.0

- Property `string $id` (readonly)
- Property `string $queue` (readonly)
- Property `string $type` (readonly)
- Property `array $payload` (readonly)
- Property `int $schemaVersion` (readonly)
- Property `int $attempts` (readonly)
- Property `int $maximumAttempts` (readonly)
- Property `string $leaseToken` (readonly)
- Property `string $executionClass` (readonly)

### `__construct`

```php
__construct(string $id, string $queue, string $type, array $payload, int $schemaVersion, int $attempts, int $maximumAttempts, string $leaseToken, string $executionClass = 'site')
```

Capture a reserved queue row together with the lease it was reserved under.

@param   string                $id               Identifier of the reserved job row, a UUID version 7.
@param   string                $queue            Queue name the row was claimed from.
@param   string                $type             Registered job type naming the handler that runs it.
@param   array<string, mixed>  $payload          Decoded handler arguments, keyed by argument name.
@param   int                   $schemaVersion    Version the payload was written under.
@param   int                   $attempts         Attempts including this one, counted from one.
@param   int                   $maximumAttempts  Attempt count at which a failure dead-letters the job.
@param   string                $leaseToken       Fencing token this claim stamped on the row.
@param   string                $executionClass   Backing value of the row's `JobExecutionClass`.

@throws  InvalidArgumentException  When the lease token is not a canonical UUID, or the execution
         class is not a known `JobExecutionClass` value.

@since   2.0.0

## `Kumwe\Automation\TransientFailure`

Marker a job failure carries to say that repeating the same job could still succeed.

`RetryPolicy` already treats an unrecognised failure as transient, so this exists for the one case
that would otherwise be classified the other way: a failure that extends `LogicException` or `Error`
is read as a programming defect and retired permanently. An exception raised for a lost connection,
a lock timeout, or a busy upstream that happens to sit under those hierarchies implements this so
the job is released for another attempt instead of being dead-lettered. Pushing a failure the other
way needs no marker at all: throwing `PermanentFailure` stops the retries outright.

@since  2.0.0
