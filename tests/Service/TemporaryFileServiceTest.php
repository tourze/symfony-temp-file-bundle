<?php

namespace Tourze\TempFileBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tourze\TempFileBundle\Service\TemporaryFileService;

class TemporaryFileServiceTest extends TestCase
{
    private TemporaryFileService $service;
    private array $testFiles = [];

    protected function setUp(): void
    {
        $this->service = new TemporaryFileService();
    }

    protected function tearDown(): void
    {
        // 清理测试中创建的临时文件
        foreach ($this->testFiles as $file) {
            if (file_exists($file)) {
                @unlink($file);
            }
        }
    }

    /**
     * 测试添加临时文件功能
     */
    public function testAddTemporaryFile(): void
    {
        $tempFile = '/tmp/test_file.txt';

        // 通过反射访问私有属性
        $reflection = new ReflectionClass(TemporaryFileService::class);
        $property = $reflection->getProperty('temporaryFiles');
        $property->setAccessible(true);

        // 初始状态应该是空数组
        $this->assertSame([], $property->getValue($this->service));

        // 添加临时文件
        $this->service->addTemporaryFile($tempFile);

        // 验证文件是否被添加到列表
        $this->assertSame([$tempFile], $property->getValue($this->service));
    }

    /**
     * 测试生成临时文件名功能（无扩展名）
     */
    public function testGenerateTemporaryFileNameWithoutExtension(): void
    {
        $prefix = 'test_prefix_';
        $tempFileName = $this->service->generateTemporaryFileName($prefix);

        // 记录生成的文件以便清理
        $this->testFiles[] = $tempFileName;

        // 验证生成的文件名是否包含前缀
        $this->assertStringContainsString($prefix, basename($tempFileName));

        // 验证文件是否被添加到临时文件列表
        $reflection = new ReflectionClass(TemporaryFileService::class);
        $property = $reflection->getProperty('temporaryFiles');
        $property->setAccessible(true);
        $files = $property->getValue($this->service);

        $this->assertContains($tempFileName, $files);
    }

    /**
     * 测试生成临时文件名功能（带扩展名）
     */
    public function testGenerateTemporaryFileNameWithExtension(): void
    {
        $prefix = 'test_prefix_';
        $extension = 'txt';
        $tempFileName = $this->service->generateTemporaryFileName($prefix, $extension);

        // 记录生成的文件以便清理
        $this->testFiles[] = $tempFileName;

        // 验证生成的文件名是否具有正确的扩展名
        $this->assertStringEndsWith(".$extension", $tempFileName);

        // 验证生成的文件名是否包含前缀
        $this->assertStringContainsString($prefix, basename($tempFileName));
    }

    /**
     * 测试临时文件清理功能
     */
    public function testOnTerminated(): void
    {
        // 创建一个真实的临时文件
        $tmpFile = tempnam(sys_get_temp_dir(), 'test_');
        file_put_contents($tmpFile, 'test content');

        // 确保文件存在
        $this->assertFileExists($tmpFile);

        // 添加到服务的临时文件列表
        $this->service->addTemporaryFile($tmpFile);

        // 触发终止事件处理
        $this->service->onTerminated();

        // 验证文件是否被删除
        $this->assertFileDoesNotExist($tmpFile);
    }

    /**
     * 测试重置功能
     */
    public function testReset(): void
    {
        // 添加一个临时文件
        $this->service->addTemporaryFile('/tmp/some_file.txt');

        // 通过反射访问私有属性
        $reflection = new ReflectionClass(TemporaryFileService::class);
        $property = $reflection->getProperty('temporaryFiles');
        $property->setAccessible(true);

        // 验证文件已添加
        $this->assertNotEmpty($property->getValue($this->service));

        // 重置
        $this->service->reset();

        // 验证列表已清空
        $this->assertSame([], $property->getValue($this->service));
    }
} 