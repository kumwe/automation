<?php

declare(strict_types=1);

use Kumwe\Automation\ConfigProvider;
use Kumwe\Automation\CronExpression;
use Kumwe\Automation\FailureClassification;

require dirname(__DIR__) . '/vendor/autoload.php';

$next = (new CronExpression('0 8 * * 1-5'))->next(
    new DateTimeImmutable('2026-09-07T05:00:00Z'),
    'Africa/Windhoek',
);
if ($next->format(DATE_ATOM) !== '2026-09-07T06:00:00+00:00') {
    throw new RuntimeException('Unexpected next-run instant.');
}
$config = (new ConfigProvider())();
if ($config['kumwe']['automation']['maximum_delay_seconds'] !== 300) {
    throw new RuntimeException('Unexpected retry defaults.');
}
echo $next->format(DATE_ATOM) . ' ' . FailureClassification::TRANSIENT->value . "\n";
