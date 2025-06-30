<?php

namespace Tourze\TempFileBundle\Service;

use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Service\ResetInterface;

/**
 * 有时候我们需要在过程中生成一些临时文件，为了防止忘记删除，我们在这里再做一次检测
 */
#[AutoconfigureTag(name: 'as-coroutine')]
class TemporaryFileService implements ResetInterface
{
    /**
     * @var array 临时文件列表
     */
    private array $temporaryFiles = [];

    public function addTemporaryFile(string $file): void
    {
        $this->temporaryFiles[] = $file;
    }

    /**
     * 生成一个符合格式的临时文件名，同时这种生成的地址会在请求结束后自动清理
     */
    public function generateTemporaryFileName(string $prefix, ?string $ext = null): string
    {
        $filename = tempnam(sys_get_temp_dir(), $prefix);
        if (null !== $ext) {
            $filename .= ".$ext";
        }
        $this->addTemporaryFile($filename);

        return $filename;
    }

    #[AsEventListener(event: KernelEvents::TERMINATE, priority: -100)]
    #[AsEventListener(event: KernelEvents::EXCEPTION, priority: -100)]
    #[AsEventListener(event: ConsoleEvents::TERMINATE, priority: -100)]
    #[AsEventListener(event: ConsoleEvents::ERROR, priority: -100)]
    public function onTerminated(): void
    {
        while (!empty($this->temporaryFiles)) {
            $file = array_shift($this->temporaryFiles);
            @unlink($file);
        }
        $this->reset();
    }

    public function reset(): void
    {
        $this->temporaryFiles = [];
    }
}
