<?php

namespace Tourze\TempFileBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tourze\TempFileBundle\TempFileBundle;

class TempFileBundleTest extends TestCase
{
    public function testBundle(): void
    {
        $bundle = new TempFileBundle();
        $this->assertInstanceOf(TempFileBundle::class, $bundle);
    }
}