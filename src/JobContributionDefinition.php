<?php

declare(strict_types=1);

namespace Kumwe\Automation;

use Kumwe\CanonicalJson\CanonicalEncoder;

use Kumwe\Automation\Internal\DeclarationValidator;

use Kumwe\Contribution\ContributionDefinition;

use InvalidArgumentException;

/**
 * Declarative job handler and payload contract for trusted runtime compilation.
 *
 * @since  0.2.0
 */
final readonly class JobContributionDefinition implements ContributionDefinition
{
    /**
     * Closed, bounded JSON schema for submitted job payloads.
     *
     * @var    array<string, mixed>  Declarative payload schema.
     * @since  0.2.0
     */
    private array $payloadSchema;

    /**
     * Define one contributed job type.
     *
     * @param   string                $jobType           Namespaced job type.
     * @param   int                   $schemaVersion     Payload schema revision.
     * @param   string                $handlerVersion    Executable handler revision.
     * @param   array<string, mixed>  $payloadSchema     Declarative JSON Schema subset.
     * @param   string                $queue             Default queue.
     * @param   int                   $maximumAttempts   Default retry budget.
     * @param   bool                  $installationWide  Whether work is installation rather than site scoped.
     *
     * @throws  InvalidArgumentException  When a declaration value is invalid.
     *
     * @since   0.2.0
     */
    public function __construct(
        private readonly CanonicalEncoder $canonicalJson,
        private string $jobType,
        private int $schemaVersion,
        private string $handlerVersion,
        array $payloadSchema,
        private string $queue = 'default',
        private int $maximumAttempts = 5,
        private bool $installationWide = false,
    ) {
        DeclarationValidator::identifier($jobType, 'Job type');
        DeclarationValidator::token($handlerVersion, 'Job handler version', 64);
        DeclarationValidator::token($queue, 'Job queue', 64);
        DeclarationValidator::object($canonicalJson, $payloadSchema, 'Job payload schema');
        if ($schemaVersion < 1 || $schemaVersion > 65_535 || $maximumAttempts < 1 || $maximumAttempts > 100) {
            throw new InvalidArgumentException('The job schema version or attempt budget is invalid.');
        }
        $this->payloadSchema = $payloadSchema;
    }

    /**
     * Return the stable identifier for the job contribution definition.
     *
     * @return  string  Job type.
     *
     * @since   0.2.0
     */
    public function identifier(): string
    {
        return $this->jobType;
    }

    /**
     * Return the event payload schema version.
     *
     * @return  int  Payload schema revision.
     *
     * @since   0.2.0
     */
    public function schemaVersion(): int
    {
        return $this->schemaVersion;
    }

    /**
     * Return the handler implementation version used for compatibility checks.
     *
     * @return  string  Executable handler revision.
     *
     * @since   0.2.0
     */
    public function handlerVersion(): string
    {
        return $this->handlerVersion;
    }

    /**
     * Return the bounded JSON schema governing the payload.
     *
     * @return  array<string, mixed>  Declarative payload schema.
     *
     * @since   0.2.0
     */
    public function payloadSchema(): array
    {
        return $this->payloadSchema;
    }

    /**
     * Return the declared durable queue identifier.
     *
     * @return  string  Default logical queue.
     *
     * @since   0.2.0
     */
    public function queue(): string
    {
        return $this->queue;
    }

    /**
     * Return the maximum number of delivery attempts.
     *
     * @return  int  Retry attempt budget.
     *
     * @since   0.2.0
     */
    public function maximumAttempts(): int
    {
        return $this->maximumAttempts;
    }

    /**
     * Return the installation wide carried by this job contribution definition.
     *
     * @return  bool  Whether the handler executes outside a site scope.
     *
     * @since   0.2.0
     */
    public function installationWide(): bool
    {
        return $this->installationWide;
    }

    /**
     * Serialize the job contribution definition for durable storage or inspection.
     *
     * @return  array<string, mixed>  Canonical publication representation.
     *
     * @since   0.2.0
     */
    public function toArray(): array
    {
        return [
            'job_type' => $this->jobType,
            'schema_version' => $this->schemaVersion,
            'handler_version' => $this->handlerVersion,
            'payload_schema' => $this->payloadSchema,
            'queue' => $this->queue,
            'maximum_attempts' => $this->maximumAttempts,
            'installation_wide' => $this->installationWide,
        ];
    }

    /**
     * Parse the closed manifest representation of a job contribution.
     *
     * @param   array<string, mixed>  $data  Manifest contribution object.
     *
     * @return  self  Validated job definition.
     *
     * @since   0.2.0
     */
    public static function fromArray(CanonicalEncoder $canonicalJson, array $data): self
    {
        DeclarationValidator::keys($data, [
            'job_type', 'schema_version', 'handler_version', 'payload_schema', 'queue',
            'maximum_attempts', 'installation_wide',
        ], 'Job contribution definition');
        return new self(
            $canonicalJson,
            DeclarationValidator::string($data, 'job_type'),
            DeclarationValidator::integer($data, 'schema_version'),
            DeclarationValidator::string($data, 'handler_version'),
            DeclarationValidator::objectField($data, 'payload_schema'),
            DeclarationValidator::string($data, 'queue'),
            DeclarationValidator::integer($data, 'maximum_attempts'),
            DeclarationValidator::boolean($data, 'installation_wide'),
        );
    }
}
