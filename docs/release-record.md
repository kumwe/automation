---
schema: kumwe-package-release-record/v1
artifact_kind: framework_php
migration_id: KUMWE-MIG-2026-026
change_set: KUMWE-CS-2026-026
target:
  repository: https://github.com/kumwe/automation
  artifact_identity: kumwe/automation
  canonical_namespace_or_abi: Kumwe\Automation
source:
  app:
    repository: https://github.com/kumwe/app
    baseline_commit: 24ecf956423c18933e824b43cea1bfb9127a79a9
    examined_paths:
      - src/Application/Automation/AutomationNotFound.php
      - src/Application/Automation/CryptographicJitterSource.php
      - src/Application/Automation/ExpiredJobLease.php
      - src/Application/Automation/FailureClassification.php
      - src/Application/Automation/JitterSource.php
      - src/Application/Automation/JobEnvelope.php
      - src/Application/Automation/JobExecutionClass.php
      - src/Application/Automation/JobHandler.php
      - src/Application/Automation/JobHandlerRegistry.php
      - src/Application/Automation/JobLease.php
      - src/Application/Automation/JobQueue.php
      - src/Application/Automation/JobStatus.php
      - src/Application/Automation/PermanentFailure.php
      - src/Application/Automation/QueueRuntimePolicy.php
      - src/Application/Automation/QueueRuntimePolicyCatalog.php
      - src/Application/Automation/RetryDecision.php
      - src/Application/Automation/RetryPolicy.php
      - src/Application/Automation/StoredJob.php
      - src/Application/Automation/TransientFailure.php
      - src/Automation/Domain/CronExpression.php
      - src/BusinessIntegration/Domain/QueueContributionDefinition.php
      - src/BusinessIntegration/Domain/ScheduleContributionDefinition.php
      - composer.json
      - docs/architecture/capability-index.md
    old_namespace_roots:
      - Kumwe\App\Application\Automation\
      - Kumwe\App\Automation\Domain\
      - Kumwe\App\BusinessIntegration\Domain\
    capability_index_sha256: null
  semantic_inputs: []
  examined_dependencies:
    - php ^8.5
    - kumwe/canonical-json 0.1.1
    - kumwe/contribution 0.1.1
    - kumwe/access-context 0.1.2
    - psr/clock ^1.0
    - psr/container ^2.0
framework_php:
  composer_package: kumwe/automation
  canonical_namespace: Kumwe\Automation
  public_api_manifest: resources/public-api/v1.json
  capability_manifest: resources/capabilities/v1.json
  service_map: resources/service-map/v1.json
  extracted_symbols:
    - old_fqcn: Kumwe\App\Automation\Domain\CronExpression
      new_fqcn: Kumwe\Automation\CronExpression
      source_path: src/Automation/Domain/CronExpression.php
      target_path: src/CronExpression.php
      kind: class
      public_methods:
        - __construct
        - __toString
        - next
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\RetryPolicy
      new_fqcn: Kumwe\Automation\RetryPolicy
      source_path: src/Application/Automation/RetryPolicy.php
      target_path: src/RetryPolicy.php
      kind: class
      public_methods:
        - __construct
        - classify
        - decide
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\RetryDecision
      new_fqcn: Kumwe\Automation\RetryDecision
      source_path: src/Application/Automation/RetryDecision.php
      target_path: src/RetryDecision.php
      kind: class
      public_methods:
        - __construct
      public_properties:
        - classification
        - delaySeconds
        - retryAt
        - shouldRetry
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\JitterSource
      new_fqcn: Kumwe\Automation\JitterSource
      source_path: src/Application/Automation/JitterSource.php
      target_path: src/JitterSource.php
      kind: interface
      public_methods:
        - between
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\CryptographicJitterSource
      new_fqcn: Kumwe\Automation\CryptographicJitterSource
      source_path: src/Application/Automation/CryptographicJitterSource.php
      target_path: src/CryptographicJitterSource.php
      kind: class
      public_methods:
        - between
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\FailureClassification
      new_fqcn: Kumwe\Automation\FailureClassification
      source_path: src/Application/Automation/FailureClassification.php
      target_path: src/FailureClassification.php
      kind: enum
      public_methods:
        - cases
        - from
        - tryFrom
      public_properties:
        - name
        - value
      public_constants:
        - PERMANENT
        - TRANSIENT
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\PermanentFailure
      new_fqcn: Kumwe\Automation\PermanentFailure
      source_path: src/Application/Automation/PermanentFailure.php
      target_path: src/PermanentFailure.php
      kind: class
      public_methods: []
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\TransientFailure
      new_fqcn: Kumwe\Automation\TransientFailure
      source_path: src/Application/Automation/TransientFailure.php
      target_path: src/TransientFailure.php
      kind: interface
      public_methods: []
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\JobEnvelope
      new_fqcn: Kumwe\Automation\JobEnvelope
      source_path: src/Application/Automation/JobEnvelope.php
      target_path: src/JobEnvelope.php
      kind: class
      public_methods:
        - attempts
        - availableAt
        - claim
        - complete
        - createdAt
        - id
        - isClaimableAt
        - lease
        - maximumAttempts
        - payload
        - pending
        - priority
        - queue
        - releaseExpiredLease
        - releaseForRetry
        - renewLease
        - schemaVersion
        - status
        - type
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\JobLease
      new_fqcn: Kumwe\Automation\JobLease
      source_path: src/Application/Automation/JobLease.php
      target_path: src/JobLease.php
      kind: class
      public_methods:
        - __construct
        - acquiredAt
        - assertActiveOwner
        - expiresAt
        - isExpiredAt
        - owner
        - renew
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\JobStatus
      new_fqcn: Kumwe\Automation\JobStatus
      source_path: src/Application/Automation/JobStatus.php
      target_path: src/JobStatus.php
      kind: enum
      public_methods:
        - cases
        - from
        - tryFrom
      public_properties:
        - name
        - value
      public_constants:
        - CANCELED
        - COMPLETED
        - DEAD
        - PENDING
        - RESERVED
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\StoredJob
      new_fqcn: Kumwe\Automation\StoredJob
      source_path: src/Application/Automation/StoredJob.php
      target_path: src/StoredJob.php
      kind: class
      public_methods:
        - __construct
      public_properties:
        - attempts
        - executionClass
        - id
        - leaseToken
        - maximumAttempts
        - payload
        - queue
        - schemaVersion
        - type
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\JobExecutionClass
      new_fqcn: Kumwe\Automation\JobExecutionClass
      source_path: src/Application/Automation/JobExecutionClass.php
      target_path: src/JobExecutionClass.php
      kind: enum
      public_methods:
        - cases
        - from
        - tryFrom
      public_properties:
        - name
        - value
      public_constants:
        - Installation
        - Site
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\JobQueue
      new_fqcn: Kumwe\Automation\JobQueue
      source_path: src/Application/Automation/JobQueue.php
      target_path: src/JobQueue.php
      kind: interface
      public_methods:
        - all
        - cancel
        - claim
        - complete
        - disconnect
        - enqueue
        - fail
        - heartbeat
        - renew
        - retry
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\JobHandler
      new_fqcn: Kumwe\Automation\JobHandler
      source_path: src/Application/Automation/JobHandler.php
      target_path: src/JobHandler.php
      kind: interface
      public_methods:
        - handle
        - type
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\JobHandlerRegistry
      new_fqcn: Kumwe\Automation\JobHandlerRegistry
      source_path: src/Application/Automation/JobHandlerRegistry.php
      target_path: src/JobHandlerRegistry.php
      kind: class
      public_methods:
        - __construct
        - find
        - types
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\QueueRuntimePolicy
      new_fqcn: Kumwe\Automation\QueueRuntimePolicy
      source_path: src/Application/Automation/QueueRuntimePolicy.php
      target_path: src/QueueRuntimePolicy.php
      kind: class
      public_methods:
        - __construct
        - toArray
      public_properties:
        - leaseSeconds
        - maximumAttempts
        - maximumInFlight
        - queue
        - retentionDays
        - runtimeGeneration
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\QueueRuntimePolicyCatalog
      new_fqcn: Kumwe\Automation\QueueRuntimePolicyCatalog
      source_path: src/Application/Automation/QueueRuntimePolicyCatalog.php
      target_path: src/QueueRuntimePolicyCatalog.php
      kind: interface
      public_methods:
        - maximumAttempts
        - policies
        - policy
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\ExpiredJobLease
      new_fqcn: Kumwe\Automation\ExpiredJobLease
      source_path: src/Application/Automation/ExpiredJobLease.php
      target_path: src/ExpiredJobLease.php
      kind: class
      public_methods: []
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\Application\Automation\AutomationNotFound
      new_fqcn: Kumwe\Automation\AutomationNotFound
      source_path: src/Application/Automation/AutomationNotFound.php
      target_path: src/AutomationNotFound.php
      kind: class
      public_methods: []
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\BusinessIntegration\Domain\QueueContributionDefinition
      new_fqcn: Kumwe\Automation\QueueContributionDefinition
      source_path: src/BusinessIntegration/Domain/QueueContributionDefinition.php
      target_path: src/QueueContributionDefinition.php
      kind: class
      public_methods:
        - __construct
        - fromArray
        - identifier
        - leaseSeconds
        - maximumAttempts
        - maximumInFlight
        - retentionDays
        - toArray
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\App\BusinessIntegration\Domain\ScheduleContributionDefinition
      new_fqcn: Kumwe\Automation\ScheduleContributionDefinition
      source_path: src/BusinessIntegration/Domain/ScheduleContributionDefinition.php
      target_path: src/ScheduleContributionDefinition.php
      kind: class
      public_methods:
        - __construct
        - cronExpression
        - enabled
        - fromArray
        - identifier
        - jobType
        - payload
        - queue
        - siteIdentifier
        - timezone
        - toArray
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\Extension\Spi\BusinessIntegration\Domain\JobContributionDefinition
      new_fqcn: Kumwe\Automation\JobContributionDefinition
      source_path: src/Spi/BusinessIntegration/Domain/JobContributionDefinition.php
      target_path: src/JobContributionDefinition.php
      kind: class
      public_methods:
        - __construct
        - fromArray
        - handlerVersion
        - identifier
        - installationWide
        - maximumAttempts
        - payloadSchema
        - queue
        - schemaVersion
        - toArray
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
    - old_fqcn: Kumwe\Extension\Spi\Application\Automation\JobDeclaration
      new_fqcn: Kumwe\Automation\JobDeclaration
      source_path: src/Spi/Application/Automation/JobDeclaration.php
      target_path: src/JobDeclaration.php
      kind: class
      public_methods:
        - fromManifest
        - schemaVersion
        - toArray
        - type
      public_properties: []
      public_constants: []
      exceptions: []
      serialization_contract: Explicit scalar projections documented in docs/public-api.md; PHP native serialization is not a durable wire or authority contract.
      compatibility: Portable behavior is retained under the canonical namespace. Package-owned boundary and regression tests document deliberate validation and scheduling corrections.
  consumers:
    app_code:
      - src/Application/Automation/Job/EnforceAuditRetentionHandler.php
      - src/Application/Automation/Job/PurgeAdministratorSessionsHandler.php
      - src/Application/Automation/Job/PurgeBusinessRecordIdempotencyHandler.php
      - src/Application/Automation/Job/PurgeIdempotencyRecordsHandler.php
      - src/Application/Automation/Job/PurgeStudioContentAuthoringContextsHandler.php
      - src/Application/Automation/Job/RebuildExtensionMapHandler.php
      - src/Application/Automation/Job/RecordAuditAnchorHandler.php
      - src/Application/Automation/Job/RotateRecordSecretsHandler.php
      - src/Application/Automation/Job/SynchronizeTrustRevocationsHandler.php
      - src/Application/Automation/Job/TransitionContentHandler.php
      - src/Application/Automation/Job/VerifyAuditTrailHandler.php
      - src/BusinessIntegration/Application/DurableOutboundAdapterDispatcher.php
      - src/BusinessIntegration/Application/InboxStore.php
      - src/BusinessIntegration/Application/IntegrationEventConsumerDispatcher.php
      - src/BusinessIntegration/Application/JobQueueIntegrationEventHandler.php
      - src/BusinessIntegration/Application/JobQueueProcessWorkHandler.php
      - src/BusinessIntegration/Application/OutboxDispatcher.php
      - src/BusinessIntegration/Application/OutboxStore.php
      - src/BusinessIntegration/Application/ProcessManagerStore.php
      - src/BusinessIntegration/Application/ProcessWorkDispatcher.php
      - src/BusinessIntegration/Application/ValidatedContributedJobHandler.php
      - src/BusinessIntegration/Domain/ScheduleContributionDefinition.php
      - src/BusinessIntegration/Infrastructure/ContributedQueueRuntimePolicyCatalog.php
      - src/BusinessIntegration/Infrastructure/ContributedScheduleSynchronizer.php
      - src/BusinessIntegration/Infrastructure/DoctrineInboxStore.php
      - src/BusinessIntegration/Infrastructure/DoctrineOutboxStore.php
      - src/BusinessIntegration/Infrastructure/DoctrineProcessManagerStore.php
      - src/BusinessIntegration/Infrastructure/RuntimeIntegrationEventTransport.php
      - src/BusinessReporting/Application/GenerateReportExportHandler.php
      - src/BusinessReporting/Infrastructure/JobQueueExportJobDispatcher.php
      - src/Delivery/Console/Command/QueueWorkCommand.php
      - src/Delivery/Http/Api/Automation/AutomationApiHandler.php
      - src/Extension/Contribution/CanonicalManifestInterpreter.php
      - src/Infrastructure/Automation/DoctrineJobQueue.php
      - src/Infrastructure/Automation/DoctrineQueueRuntimeOperations.php
      - src/Infrastructure/Automation/DoctrineScheduler.php
      - src/Infrastructure/Mcp/McpToolErrorVocabulary.php
      - src/Infrastructure/Persistence/Migration/AuditTamperEvidenceMigration.php
      - src/Infrastructure/Persistence/Migration/BusinessRecordIdempotencyRetentionMigration.php
      - src/Infrastructure/Persistence/Migration/InstallationGlobalAutomationMigration.php
      - src/Infrastructure/Persistence/Migration/StudioContentAuthoringContextRetentionMigration.php
      - src/Kernel/ContainerFactory.php
    configuration_and_di: []
    reflection_and_string_references:
      - Recompute same-namespace, reflected and dynamically constructed names before App adoption; exact source inventory is evidence, not a complete dynamic reference proof.
    fixtures_and_examples:
      - examples/consumer.php
    external:
      - src/Manifest/ManifestContributionGraphValidator.php
      - src/Manifest/ManifestContributions.php
      - src/Spi/Application/Automation/JobHandler.php
  dependency_injection:
    mode: config-provider
    provider: Kumwe\Automation\ConfigProvider
    factories:
      - Kumwe\Automation\Container\CryptographicJitterSourceFactory
      - Kumwe\Automation\Container\RetryPolicyFactory
      - Kumwe\Automation\Container\JobHandlerRegistryFactory
    aliases:
      - Kumwe\Automation\JitterSource -> Kumwe\Automation\CryptographicJitterSource
    service_lifetimes:
      - "Kumwe\\Automation\\CryptographicJitterSource: shared"
      - "Kumwe\\Automation\\RetryPolicy: shared"
      - "Kumwe\\Automation\\JobHandlerRegistry: shared"
    configuration_keys:
      - kumwe.automation.base_delay_seconds
      - kumwe.automation.maximum_delay_seconds
      - kumwe.automation.handlers
    provider_absence_reason: null
ownership:
  responsibility: Portable schedules, jittered retry policy, run requests and explicit job registration.
  non_responsibilities:
    - Host trust and final authorization
    - Persistence, durable transactions, worker and transport lifecycle
    - App runtime adoption and native release publication
  allowed_dependency_ceiling:
    - php
    - kumwe/canonical-json
    - kumwe/contribution
    - kumwe/access-context
    - psr/clock
    - psr/container
  implementation_owner: kumwe/automation
  next_consumer: kumwe/app
  public_manifests:
    - path: resources/public-api/v1.json
      sha256: 5528055c23afaea3711de77e0e66f84b0e122df520542fb61c8b8fd9f0c8cf53
    - path: resources/capabilities/v1.json
      sha256: 6a48f2fb2dbac9d9293153027b9ce2efcc37e885406576931d8f8e309d909c95
    - path: resources/service-map/v1.json
      sha256: 4bacfb7a2eb2b2dc4046b85826bf53bda5c4ef24a23c5b9b69c2ad0bf62b05c6
  intentionally_excluded:
    - Cron, retry, handler dispatch and job declarations are implemented and tested here. The App retains durable queues, scheduler claims, transactions, tenant authority, extension admission and worker orchestration.
native_cpp: null
php_extension: null
tests:
  moved_or_added:
    - tests/bootstrap.php
    - tests/container.php
    - tests/run.php
  remain_in_app_or_consumer:
    - tests/Architecture/TransactionSeamBoundaryTest.php
    - tests/Functional/Extension/LiveSurfaceContractParityTest.php
    - tests/Integration/Automation/AutomationManagementIntegrationTest.php
    - tests/Integration/Automation/DatabaseLossRecoveryIntegrationTest.php
    - tests/Integration/Automation/KilledWorkerRecoveryIntegrationTest.php
    - tests/Integration/Automation/SchedulerOccurrenceContentionIntegrationTest.php
    - tests/Integration/Automation/WorkerConnectionLossKillPointIntegrationTest.php
    - tests/Integration/BusinessIntegration/BusinessIntegrationPersistenceTest.php
    - tests/Integration/BusinessIntegration/HungEndpointDeadlineIntegrationTest.php
    - tests/Integration/BusinessIntegration/PoisonAndDeadLetterIntegrationTest.php
    - tests/Integration/Extension/GeneratedExtensionLifecycleIntegrationTest.php
    - tests/Integration/Extension/ManifestGenerationLifecycleIntegrationTest.php
    - tests/Integration/Persistence/MigrationIntegrationTest.php
    - tests/Support/DrillDirectedJobHandler.php
    - tests/Support/killable-worker.php
    - tests/Unit/Application/Authorization/AdapterAuthorizationParityTest.php
    - tests/Unit/Application/Automation/AutomationManagementServiceTest.php
    - tests/Unit/Application/Automation/CronExpressionTest.php
    - tests/Unit/Application/Automation/JobEnvelopeTest.php
    - tests/Unit/Application/Automation/JobLeaseTest.php
    - tests/Unit/Application/Automation/RetryPolicyTest.php
    - tests/Unit/Application/Automation/WorkerTest.php
    - tests/Unit/BusinessIntegration/Application/DurableOutboundAdapterDeliveryTest.php
    - tests/Unit/BusinessIntegration/Application/JobQueueIntegrationEventHandlerTest.php
    - tests/Unit/BusinessIntegration/Application/ValidatedContributedJobHandlerTest.php
    - tests/Unit/BusinessIntegration/ConsumerDispatcherTest.php
    - tests/Unit/BusinessIntegration/Domain/IntegrationContributionDefinitionTest.php
    - tests/Unit/BusinessIntegration/DurableOutboundAdapterDispatcherTest.php
    - tests/Unit/BusinessIntegration/Infrastructure/RuntimeIntegrationEventTransportTest.php
    - tests/Unit/BusinessIntegration/OutboxDispatcherTest.php
    - tests/Unit/BusinessIntegration/ProcessWorkDispatcherTest.php
    - tests/Unit/BusinessIntegration/QueueRuntimePolicyTest.php
    - tests/Unit/Delivery/Console/Command/QueueWorkCommandTest.php
    - tests/Unit/Delivery/Http/Api/Automation/AutomationApiHandlerTest.php
    - tests/Unit/Extension/Contribution/ExtensionBindingSurfaceTest.php
    - tests/Unit/Extension/Contribution/OwnedBindingCanonicalDriftTest.php
    - tests/Unit/Extension/Runtime/TrustEnforcingJobHandlerTest.php
  split_tests:
    - Remove only library implementation assertions after verified App adoption; retain host wiring and composed behavior assertions.
  prohibited_duplicates:
    - App must not retain unit tests of vendor-owned implementation internals after adoption.
  corpora: []
documentation:
  charter: CHARTER.md
  readme: README.md
  public_api: docs/public-api.md
  architecture: docs/architecture.md
  integration_or_consumer: docs/integration.md
  examples:
    - examples/consumer.php
  changelog_record: "CHANGELOG.md ## 0.2.2"
release_expectations:
  version_policy: Exact stable sibling package pins; preserve coherent released graphs until compatible successor releases exist.
  expected_artifact_types:
    - Composer package archive
    - GitHub source archive
  required_checks:
    - composer check
    - Final hosted package CI
    - Release contract record and consumer schema validation
  required_registry_or_installer: Composer
  required_external_attestation: true
governance:
  completion_claim: false
decisions:
  - Cron matching distinguishes repeated local minutes by their UTC instants; searches and field expansion are bounded.
  - Clock, jitter, canonical encoding and admitted handler services are explicit dependencies.
  - The package owns portable scheduling and job semantics; Core owns durable queues, transactions, tenant authority and workers.
blockers: []
consumer_contract:
  permitted_only_when:
    - The selected immutable package and dependency releases have independent source, artifact and clean-consumer verification.
    - Core integration tests pass against the exact selected package version.
  consumer_repository: https://github.com/kumwe/app
  dependency_or_native_change: Pin the independently verified package version exactly; resolve Composer dependencies and run affected Core integration tests.
  namespace_or_api_replacements:
    - Kumwe\App\Automation\Domain\CronExpression -> Kumwe\Automation\CronExpression
    - Kumwe\App\Application\Automation\RetryPolicy -> Kumwe\Automation\RetryPolicy
    - Kumwe\App\Application\Automation\RetryDecision -> Kumwe\Automation\RetryDecision
    - Kumwe\App\Application\Automation\JitterSource -> Kumwe\Automation\JitterSource
    - Kumwe\App\Application\Automation\CryptographicJitterSource -> Kumwe\Automation\CryptographicJitterSource
    - Kumwe\App\Application\Automation\FailureClassification -> Kumwe\Automation\FailureClassification
    - Kumwe\App\Application\Automation\PermanentFailure -> Kumwe\Automation\PermanentFailure
    - Kumwe\App\Application\Automation\TransientFailure -> Kumwe\Automation\TransientFailure
    - Kumwe\App\Application\Automation\JobEnvelope -> Kumwe\Automation\JobEnvelope
    - Kumwe\App\Application\Automation\JobLease -> Kumwe\Automation\JobLease
    - Kumwe\App\Application\Automation\JobStatus -> Kumwe\Automation\JobStatus
    - Kumwe\App\Application\Automation\StoredJob -> Kumwe\Automation\StoredJob
    - Kumwe\App\Application\Automation\JobExecutionClass -> Kumwe\Automation\JobExecutionClass
    - Kumwe\App\Application\Automation\JobQueue -> Kumwe\Automation\JobQueue
    - Kumwe\App\Application\Automation\JobHandler -> Kumwe\Automation\JobHandler
    - Kumwe\App\Application\Automation\JobHandlerRegistry -> Kumwe\Automation\JobHandlerRegistry
    - Kumwe\App\Application\Automation\QueueRuntimePolicy -> Kumwe\Automation\QueueRuntimePolicy
    - Kumwe\App\Application\Automation\QueueRuntimePolicyCatalog -> Kumwe\Automation\QueueRuntimePolicyCatalog
    - Kumwe\App\Application\Automation\ExpiredJobLease -> Kumwe\Automation\ExpiredJobLease
    - Kumwe\App\Application\Automation\AutomationNotFound -> Kumwe\Automation\AutomationNotFound
    - Kumwe\App\BusinessIntegration\Domain\QueueContributionDefinition -> Kumwe\Automation\QueueContributionDefinition
    - Kumwe\App\BusinessIntegration\Domain\ScheduleContributionDefinition -> Kumwe\Automation\ScheduleContributionDefinition
    - Kumwe\Extension\Spi\BusinessIntegration\Domain\JobContributionDefinition -> Kumwe\Automation\JobContributionDefinition
    - Kumwe\Extension\Spi\Application\Automation\JobDeclaration -> Kumwe\Automation\JobDeclaration
  files_to_update:
    - composer.json
    - composer.lock
    - src/Application/Automation/Job/EnforceAuditRetentionHandler.php
    - src/Application/Automation/Job/PurgeAdministratorSessionsHandler.php
    - src/Application/Automation/Job/PurgeBusinessRecordIdempotencyHandler.php
    - src/Application/Automation/Job/PurgeIdempotencyRecordsHandler.php
    - src/Application/Automation/Job/PurgeStudioContentAuthoringContextsHandler.php
    - src/Application/Automation/Job/RebuildExtensionMapHandler.php
    - src/Application/Automation/Job/RecordAuditAnchorHandler.php
    - src/Application/Automation/Job/RotateRecordSecretsHandler.php
    - src/Application/Automation/Job/SynchronizeTrustRevocationsHandler.php
    - src/Application/Automation/Job/TransitionContentHandler.php
    - src/Application/Automation/Job/VerifyAuditTrailHandler.php
    - src/BusinessIntegration/Application/DurableOutboundAdapterDispatcher.php
    - src/BusinessIntegration/Application/InboxStore.php
    - src/BusinessIntegration/Application/IntegrationEventConsumerDispatcher.php
    - src/BusinessIntegration/Application/JobQueueIntegrationEventHandler.php
    - src/BusinessIntegration/Application/JobQueueProcessWorkHandler.php
    - src/BusinessIntegration/Application/OutboxDispatcher.php
    - src/BusinessIntegration/Application/OutboxStore.php
    - src/BusinessIntegration/Application/ProcessManagerStore.php
    - src/BusinessIntegration/Application/ProcessWorkDispatcher.php
    - src/BusinessIntegration/Application/ValidatedContributedJobHandler.php
    - src/BusinessIntegration/Domain/ScheduleContributionDefinition.php
    - src/BusinessIntegration/Infrastructure/ContributedQueueRuntimePolicyCatalog.php
    - src/BusinessIntegration/Infrastructure/ContributedScheduleSynchronizer.php
    - src/BusinessIntegration/Infrastructure/DoctrineInboxStore.php
    - src/BusinessIntegration/Infrastructure/DoctrineOutboxStore.php
    - src/BusinessIntegration/Infrastructure/DoctrineProcessManagerStore.php
    - src/BusinessIntegration/Infrastructure/RuntimeIntegrationEventTransport.php
    - src/BusinessReporting/Application/GenerateReportExportHandler.php
    - src/BusinessReporting/Infrastructure/JobQueueExportJobDispatcher.php
    - src/Delivery/Console/Command/QueueWorkCommand.php
    - src/Delivery/Http/Api/Automation/AutomationApiHandler.php
    - src/Extension/Contribution/CanonicalManifestInterpreter.php
    - src/Infrastructure/Automation/DoctrineJobQueue.php
    - src/Infrastructure/Automation/DoctrineQueueRuntimeOperations.php
    - src/Infrastructure/Automation/DoctrineScheduler.php
    - src/Infrastructure/Mcp/McpToolErrorVocabulary.php
    - src/Infrastructure/Persistence/Migration/AuditTamperEvidenceMigration.php
    - src/Infrastructure/Persistence/Migration/BusinessRecordIdempotencyRetentionMigration.php
    - src/Infrastructure/Persistence/Migration/InstallationGlobalAutomationMigration.php
    - src/Infrastructure/Persistence/Migration/StudioContentAuthoringContextRetentionMigration.php
    - src/Kernel/ContainerFactory.php
  files_to_remove:
    - src/Application/Automation/AutomationNotFound.php
    - src/Application/Automation/CryptographicJitterSource.php
    - src/Application/Automation/ExpiredJobLease.php
    - src/Application/Automation/FailureClassification.php
    - src/Application/Automation/JitterSource.php
    - src/Application/Automation/JobEnvelope.php
    - src/Application/Automation/JobExecutionClass.php
    - src/Application/Automation/JobHandler.php
    - src/Application/Automation/JobHandlerRegistry.php
    - src/Application/Automation/JobLease.php
    - src/Application/Automation/JobQueue.php
    - src/Application/Automation/JobStatus.php
    - src/Application/Automation/PermanentFailure.php
    - src/Application/Automation/QueueRuntimePolicy.php
    - src/Application/Automation/QueueRuntimePolicyCatalog.php
    - src/Application/Automation/RetryDecision.php
    - src/Application/Automation/RetryPolicy.php
    - src/Application/Automation/StoredJob.php
    - src/Application/Automation/TransientFailure.php
    - src/Automation/Domain/CronExpression.php
    - src/BusinessIntegration/Domain/QueueContributionDefinition.php
    - src/BusinessIntegration/Domain/ScheduleContributionDefinition.php
  tests_to_remove:
    - Implementation-owned portions only, after the package behavior suite and App integration suite pass.
  tests_to_retain_or_add:
    - tests/Architecture/TransactionSeamBoundaryTest.php
    - tests/Functional/Extension/LiveSurfaceContractParityTest.php
    - tests/Integration/Automation/AutomationManagementIntegrationTest.php
    - tests/Integration/Automation/DatabaseLossRecoveryIntegrationTest.php
    - tests/Integration/Automation/KilledWorkerRecoveryIntegrationTest.php
    - tests/Integration/Automation/SchedulerOccurrenceContentionIntegrationTest.php
    - tests/Integration/Automation/WorkerConnectionLossKillPointIntegrationTest.php
    - tests/Integration/BusinessIntegration/BusinessIntegrationPersistenceTest.php
    - tests/Integration/BusinessIntegration/HungEndpointDeadlineIntegrationTest.php
    - tests/Integration/BusinessIntegration/PoisonAndDeadLetterIntegrationTest.php
    - tests/Integration/Extension/GeneratedExtensionLifecycleIntegrationTest.php
    - tests/Integration/Extension/ManifestGenerationLifecycleIntegrationTest.php
    - tests/Integration/Persistence/MigrationIntegrationTest.php
    - tests/Support/DrillDirectedJobHandler.php
    - tests/Support/killable-worker.php
    - tests/Unit/Application/Authorization/AdapterAuthorizationParityTest.php
    - tests/Unit/Application/Automation/AutomationManagementServiceTest.php
    - tests/Unit/Application/Automation/CronExpressionTest.php
    - tests/Unit/Application/Automation/JobEnvelopeTest.php
    - tests/Unit/Application/Automation/JobLeaseTest.php
    - tests/Unit/Application/Automation/RetryPolicyTest.php
    - tests/Unit/Application/Automation/WorkerTest.php
    - tests/Unit/BusinessIntegration/Application/DurableOutboundAdapterDeliveryTest.php
    - tests/Unit/BusinessIntegration/Application/JobQueueIntegrationEventHandlerTest.php
    - tests/Unit/BusinessIntegration/Application/ValidatedContributedJobHandlerTest.php
    - tests/Unit/BusinessIntegration/ConsumerDispatcherTest.php
    - tests/Unit/BusinessIntegration/Domain/IntegrationContributionDefinitionTest.php
    - tests/Unit/BusinessIntegration/DurableOutboundAdapterDispatcherTest.php
    - tests/Unit/BusinessIntegration/Infrastructure/RuntimeIntegrationEventTransportTest.php
    - tests/Unit/BusinessIntegration/OutboxDispatcherTest.php
    - tests/Unit/BusinessIntegration/ProcessWorkDispatcherTest.php
    - tests/Unit/BusinessIntegration/QueueRuntimePolicyTest.php
    - tests/Unit/Delivery/Console/Command/QueueWorkCommandTest.php
    - tests/Unit/Delivery/Http/Api/Automation/AutomationApiHandlerTest.php
    - tests/Unit/Extension/Contribution/ExtensionBindingSurfaceTest.php
    - tests/Unit/Extension/Contribution/OwnedBindingCanonicalDriftTest.php
    - tests/Unit/Extension/Runtime/TrustEnforcingJobHandlerTest.php
  di_or_provisioning_changes:
    - Register Kumwe\Automation\ConfigProvider and provide all explicit host ports documented in docs/integration.md.
  capability_index_changes:
    - Record ownership from the verified package capability and public API manifests.
  changelog_and_evidence_changes:
    - Record exact source, package archive and dependency identities in the external release attestation and App integration ledger.
  verification_commands:
    - composer check
    - Affected App integration suites
    - Complete App package governance gate
---
## Package contract

Automation provides portable cron scheduling, retry policy, job/lease values and queue/schedule declarations.
Core owns durable queues, worker and scheduler execution, signals, deadline enforcement and lifecycle.
This record states consumer requirements; it does not claim that Core has adopted a package version.

## Public API and responsibility

Use the canonical `Kumwe\Automation` types documented in [the public API](public-api.md).
The three manifests above record public shapes, capability ownership and explicit service composition.
No package service captures host authorization, tenant state or a durable connection.

## Dependencies and semantic inputs

The exact runtime requirements are in [composer.json](../composer.json). Core supplies the canonical
encoder, clock, jitter policy and trusted handler IDs. The package does not discover handlers or execute
an encoder internally. [Architecture](architecture.md) documents cron bounds, DST behavior and retry limits.

## Consumer contract

Pin an independently verified immutable release. The namespace mappings and source paths above preserve
compatibility provenance; consumers inspect current source before removing any local duplicate.
[Host composition](integration.md) documents provider registration, explicit ports, lifetimes and defaults.
Core retains persistence, contention, fencing, crash recovery and trusted-generation responsibilities.

## Test ownership

Package-owned behavior and boundary tests cover every portable public type and composition invariant.
Source, test and consumer inventories remain in `resources/migration/` as exact provenance and maintained
ownership evidence. Core retains database, worker, transaction and lifecycle acceptance tests.

## Consumer verification

`composer clean-consumer` installs the actual ZIP into a fresh authoritative Composer consumer, runs
behavior and installed-example checks and verifies both supported bootstrap modes and missing-path refusal.
Independent release evidence binds the exact source/tag, archive, manifests and dependency identities.
The package record does not supply its own external release attestation.

## Compatibility and drift

Public shape or semantic changes require review and a versioned package release. Consumers update exact
pins only after their affected integration checks pass. Existing tags and released artifacts are never
replaced; [release policy](releasing.md) specifies publication, verification and recovery.

## Validation

```bash
composer install
composer check
composer clean-consumer
```

CI results and independent release attestations live outside this embedded contract. Historical source
identifiers do not assert the current state of a consumer's code.
