<?php

namespace Tourze\TempFileBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;
use Tourze\TempFileBundle\DependencyInjection\TempFileExtension;

/**
 * @internal
 */
#[CoversClass(TempFileExtension::class)]
final class TempFileExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
}
