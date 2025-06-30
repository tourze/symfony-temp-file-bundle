<?php

namespace Tourze\TempFileBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\TempFileBundle\DependencyInjection\TempFileExtension;
use Tourze\TempFileBundle\Service\TemporaryFileService;

class TempFileExtensionTest extends TestCase
{
    private TempFileExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->extension = new TempFileExtension();
        $this->container = new ContainerBuilder();
    }

    /**
     * 测试扩展加载功能
     */
    public function testLoad(): void
    {
        // 加载扩展
        $this->extension->load([], $this->container);

        // 由于使用了自动配置，我们只需验证容器有资源定义
        $this->assertNotEmpty($this->container->getResources());
        
        // 验证配置文件已加载
        $resources = $this->container->getResources();
        $hasServiceConfig = false;
        foreach ($resources as $resource) {
            if (str_contains($resource->__toString(), 'services.yaml')) {
                $hasServiceConfig = true;
                break;
            }
        }
        $this->assertTrue($hasServiceConfig);
    }

    /**
     * 测试扩展是否正确加载配置文件
     */
    public function testLoadConfiguration(): void
    {
        // 加载扩展
        $this->extension->load([], $this->container);

        // 验证资源已加载
        $this->assertNotEmpty($this->container->getResources());
    }

    /**
     * 测试扩展是否正确处理多个配置
     */
    public function testLoadWithMultipleConfigs(): void
    {
        // 测试多个空配置
        $configs = [[], [], []];
        
        // 不应该抛出异常
        $this->extension->load($configs, $this->container);

        // 验证资源已加载
        $this->assertNotEmpty($this->container->getResources());
    }
}