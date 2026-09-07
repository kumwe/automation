<?php

declare(strict_types=1);

namespace Kumwe\Automation;

use Kumwe\Automation\Container\CryptographicJitterSourceFactory;
use Kumwe\Automation\Container\JobHandlerRegistryFactory;
use Kumwe\Automation\Container\RetryPolicyFactory;

/** Deterministic optional Laminas/Mezzio wiring for portable automation services. */
final class ConfigProvider
{
    /**
     * Return package services and safe defaults; the host must supply its ClockInterface.
     * @return array<string, mixed> Shared services, aliases and kumwe.automation options.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'factories' => [
                    CryptographicJitterSource::class => CryptographicJitterSourceFactory::class,
                    RetryPolicy::class => RetryPolicyFactory::class,
                    JobHandlerRegistry::class => JobHandlerRegistryFactory::class,
                ],
                'aliases' => [JitterSource::class => CryptographicJitterSource::class],
                'shared' => [
                    CryptographicJitterSource::class => true,
                    RetryPolicy::class => true,
                    JobHandlerRegistry::class => true,
                ],
            ],
            'kumwe' => ['automation' => [
                'base_delay_seconds' => 1,
                'maximum_delay_seconds' => 300,
                'handlers' => [],
            ]],
        ];
    }
}
