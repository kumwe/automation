<?php

declare(strict_types=1);

namespace Kumwe\Automation\Container;

use InvalidArgumentException;
use Kumwe\Automation\Internal\Options;
use Kumwe\Automation\JitterSource;
use Kumwe\Automation\RetryPolicy;
use Psr\Clock\ClockInterface;
use Psr\Container\ContainerInterface;

/** Constructs the shared policy from explicit clock, jitter and validated delay settings. */
final class RetryPolicyFactory
{
    /**
     * @param ContainerInterface $container Supplies config, ClockInterface and JitterSource.
     * @return RetryPolicy Shared policy without operation or tenant state.
     * @throws InvalidArgumentException On malformed options or incorrectly typed dependencies.
     */
    public function __invoke(ContainerInterface $container): RetryPolicy
    {
        $options = Options::from($container->has('config') ? $container->get('config') : []);
        $base = $options['base_delay_seconds'] ?? 1;
        $maximum = $options['maximum_delay_seconds'] ?? 300;
        $clock = $container->get(ClockInterface::class);
        $jitter = $container->get(JitterSource::class);
        if (
            !is_int($base) || !is_int($maximum)
            || !$clock instanceof ClockInterface || !$jitter instanceof JitterSource
        ) {
            throw new InvalidArgumentException('RetryPolicy requires integer delays, ClockInterface and JitterSource.');
        }
        return new RetryPolicy($clock, $jitter, $base, $maximum);
    }
}
