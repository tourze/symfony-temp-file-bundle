<?php

declare(strict_types=1);

namespace Tourze\TempFileBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use Tourze\TempFileBundle\TempFileBundle;

/**
 * @internal
 */
#[CoversClass(TempFileBundle::class)]
#[RunTestsInSeparateProcesses]
final class TempFileBundleTest extends AbstractBundleTestCase
{
}
