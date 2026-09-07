<?php

declare(strict_types=1);

namespace Kumwe\Automation\Internal;

use InvalidArgumentException;

/** @internal Validates only this package's explicitly supplied configuration. */
final class Options
{
    /**
     * @param mixed $configuration Effective host configuration.
     * @return array<string, mixed> Automation options; absent options use constructor defaults.
     * @throws InvalidArgumentException On malformed configuration.
     */
    public static function from(mixed $configuration): array
    {
        if (!is_array($configuration)) {
            throw new InvalidArgumentException('Container config must be an array.');
        }
        $kumwe = $configuration['kumwe'] ?? [];
        if (!is_array($kumwe)) {
            throw new InvalidArgumentException('kumwe config must be an array.');
        }
        $options = $kumwe['automation'] ?? [];
        if (
            !is_array($options) || array_diff(array_keys($options), [
            'base_delay_seconds', 'maximum_delay_seconds', 'handlers',
            ]) !== []
        ) {
            throw new InvalidArgumentException('Invalid kumwe.automation configuration.');
        }
        /** @var array<string, mixed> $options */
        return $options;
    }
}
