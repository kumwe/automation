<?php

declare(strict_types=1);

namespace Kumwe\Automation\Container;

use InvalidArgumentException;
use Kumwe\Automation\Internal\Options;
use Kumwe\Automation\JobHandler;
use Kumwe\Automation\JobHandlerRegistry;
use Psr\Container\ContainerInterface;

/** Resolves the host's explicit handler service list without discovery or trust decisions. */
final class JobHandlerRegistryFactory
{
    /**
     * @param ContainerInterface $container Supplies config and explicitly declared handler services.
     * @return JobHandlerRegistry Shared registry; duplicate types are rejected by its constructor.
     * @throws InvalidArgumentException On malformed service identifiers or non-handler services.
     */
    public function __invoke(ContainerInterface $container): JobHandlerRegistry
    {
        $options = Options::from($container->has('config') ? $container->get('config') : []);
        $identifiers = $options['handlers'] ?? [];
        if (!is_array($identifiers) || !array_is_list($identifiers)) {
            throw new InvalidArgumentException('kumwe.automation.handlers must be a list of service identifiers.');
        }
        $handlers = [];
        foreach ($identifiers as $identifier) {
            if (!is_string($identifier) || $identifier === '') {
                throw new InvalidArgumentException('A handler service identifier must be a nonempty string.');
            }
            $handler = $container->get($identifier);
            if (!$handler instanceof JobHandler) {
                throw new InvalidArgumentException('A configured handler must implement JobHandler.');
            }
            $handlers[] = $handler;
        }
        return new JobHandlerRegistry($handlers);
    }
}
