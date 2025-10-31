<?php

namespace Tourze\TempFileBundle\DependencyInjection;

use Tourze\SymfonyDependencyServiceLoader\AutoExtension;

class TempFileExtension extends AutoExtension
{
    protected function getConfigDir(): string
    {
        return __DIR__.'/../Resources/config';
    }
}
