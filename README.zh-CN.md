# symfony-temp-file-bundle

[![Latest Stable Version](https://img.shields.io/packagist/v/tourze/symfony-temp-file-bundle.svg)](https://packagist.org/packages/tourze/symfony-temp-file-bundle)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## 简介

`symfony-temp-file-bundle` 是一个为 Symfony 提供临时文件集中管理与自动清理能力的 Bundle。它能确保你在应用或命令行中生成的临时文件能在进程结束后自动清理，降低遗留临时文件的风险。

## 功能特性

- 统一管理临时文件的生成与删除
- 支持 HTTP 请求和 Console 命令的生命周期自动清理
- 简单易用的 API
- 自动集成，无需复杂配置

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
$temporaryFileService->addTemporaryFile($filePath);
```

## 详细文档

- 所有生成或注册的临时文件会在 HTTP 请求或 Console 命令结束时自动清理。
- 支持多种事件监听：`KernelEvents::TERMINATE`、`KernelEvents::EXCEPTION`、`ConsoleEvents::TERMINATE`、`ConsoleEvents::ERROR`
- 无需手动清理临时文件，减少资源泄漏风险。

## 贡献指南

- 欢迎提交 Issue 或 PR
- 遵循 PSR-12 代码规范
- 提交前请确保通过 PHPUnit 测试

## 版权和许可

MIT License © tourze

## 更新日志

详见 [CHANGELOG.md] 或 Git 提交历史。
