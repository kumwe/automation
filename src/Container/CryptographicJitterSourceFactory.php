<?php

declare(strict_types=1);

namespace Kumwe\Automation\Container;

use Kumwe\Automation\CryptographicJitterSource;
use Psr\Container\ContainerInterface;

/** Constructs the stateless secure jitter dependency without drawing randomness during wiring. */
final class CryptographicJitterSourceFactory
{
    /**
     * @param ContainerInterface $container Host composition container, never retained.
     * @return CryptographicJitterSource Shared stateless jitter source.
     */
    public function __invoke(ContainerInterface $container): CryptographicJitterSource
    {
        return new CryptographicJitterSource();
    }
}
