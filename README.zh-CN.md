# symfony-temp-file-bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Stable Version](https://img.shields.io/packagist/v/tourze/symfony-temp-file-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/symfony-temp-file-bundle)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-8892BF.svg?style=flat-square)](https://php.net/)
[![Symfony Version](https://img.shields.io/badge/symfony-%3E%3D6.4-000000.svg?style=flat-square)](https://symfony.com/)
[![Code Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen.svg?style=flat-square)](https://github.com/tourze/php-monorepo/tree/master/packages/symfony-temp-file-bundle)

## 简介

`symfony-temp-file-bundle` 是一个为 Symfony 提供临时文件集中管理与自动清理能力的 Bundle。它能确保你在应用或命令行中生成的临时文件能在进程结束后自动清理，降低遗留临时文件的风险。

## 功能特性

- **统一的临时文件管理**：集中化的临时文件创建和删除
- **自动清理**：在 HTTP 请求和控制台命令结束时自动删除文件
- **多种事件监听**：支持 `KernelEvents::TERMINATE`、`KernelEvents::EXCEPTION`、`ConsoleEvents::TERMINATE`、`ConsoleEvents::ERROR`
- **简单的 API**：易于使用的方法来生成和管理临时文件
- **零配置**：开箱即用，无需复杂设置
- **内存高效**：使用数组移位管理文件清理

## 安装说明

### 环境要求

- PHP >= 8.1
- Symfony >= 6.4

### Composer 安装

```shell
composer require tourze/symfony-temp-file-bundle
```

### 手动注册（通常 Symfony Flex 会自动注册）

在 `config/bundles.php` 中添加：

```php
Tourze\TempFileBundle\TempFileBundle::class => ['all' => true],
```

## 快速开始

### 生成临时文件

```php
use Tourze\TempFileBundle\Service\TemporaryFileService;

// 注入 TemporaryFileService
$tempFile = $temporaryFileService->generateTemporaryFileName('prefix_', 'txt');
file_put_contents($tempFile, 'hello world');
// 在请求或命令结束后，临时文件会自动被删除
```

### 添加已有临时文件以便自动清理

```php
// 注册现有文件以便自动清理
$temporaryFileService->addTemporaryFile($filePath);
```

### 生成无扩展名的临时文件

```php
// 生成无扩展名的临时文件
$tempFile = $temporaryFileService->generateTemporaryFileName('data_');
// 将创建类似的文件：/tmp/data_abc123
```

## API 文档

### TemporaryFileService

#### 方法

- `generateTemporaryFileName(string $prefix, ?string $ext = null): string`
  - 生成带有可选扩展名的临时文件名
  - 文件会自动注册以便清理
  - 返回临时文件的完整路径

- `addTemporaryFile(string $file): void`
  - 注册现有文件以便自动清理
  - 适用于在服务外部创建的文件

- `reset(): void`
  - 手动清空临时文件列表
  - 通常由事件监听器自动调用

#### 事件监听器

服务会在以下事件中自动清理临时文件：
- `KernelEvents::TERMINATE` - 正常 HTTP 请求终止
- `KernelEvents::EXCEPTION` - HTTP 请求异常
- `ConsoleEvents::TERMINATE` - 控制台命令终止
- `ConsoleEvents::ERROR` - 控制台命令错误

#### 配置

无需配置。当 Bundle 安装时，服务会自动注册和配置。

## 贡献指南

- 欢迎提交 Issue 或 PR
- 遵循 PSR-12 代码规范
- 提交前请确保通过 PHPUnit 测试

## 版权和许可

MIT License © tourze

## 更新日志

详见 [CHANGELOG.md] 或 Git 提交历史。
