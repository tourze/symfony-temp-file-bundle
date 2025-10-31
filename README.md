# symfony-temp-file-bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Stable Version](https://img.shields.io/packagist/v/tourze/symfony-temp-file-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/symfony-temp-file-bundle)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-8892BF.svg?style=flat-square)](https://php.net/)
[![Symfony Version](https://img.shields.io/badge/symfony-%3E%3D6.4-000000.svg?style=flat-square)](https://symfony.com/)
[![Code Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen.svg?style=flat-square)](https://github.com/tourze/php-monorepo/tree/master/packages/symfony-temp-file-bundle)

## Introduction

`symfony-temp-file-bundle` is a Symfony bundle for centralized management and automatic cleanup of temporary files. 
It ensures that temporary files generated during HTTP requests or console commands are automatically deleted at the end of the process, 
reducing the risk of leftover temp files.

## Features

- **Unified temporary file management**: Centralized creation and deletion of temporary files
- **Automatic cleanup**: Files are automatically deleted at the end of HTTP requests and console commands
- **Multiple event listeners**: Supports `KernelEvents::TERMINATE`, `KernelEvents::EXCEPTION`, `ConsoleEvents::TERMINATE`, `ConsoleEvents::ERROR`
- **Simple API**: Easy-to-use methods for generating and managing temporary files
- **Zero configuration**: Works out of the box with minimal setup
- **Memory efficient**: Uses array shifting to manage file cleanup

## Installation

### Requirements

- PHP >= 8.1
- Symfony >= 6.4

### Composer

```shell
composer require tourze/symfony-temp-file-bundle
```

### Manual Registration (Symfony Flex will register automatically in most cases)

Add to `config/bundles.php`:

```php
Tourze\TempFileBundle\TempFileBundle::class => ['all' => true],
```

## Quick Start

### Generate a Temporary File

```php
use Tourze\TempFileBundle\Service\TemporaryFileService;

// Inject TemporaryFileService
$tempFile = $temporaryFileService->generateTemporaryFileName('prefix_', 'txt');
file_put_contents($tempFile, 'hello world');
// The temp file will be automatically deleted at the end of the request or command
```

### Register an Existing Temp File for Auto-Cleanup

```php
// Register an existing file for automatic cleanup
$temporaryFileService->addTemporaryFile($filePath);
```

### Generate Temporary File Without Extension

```php
// Generate temporary file without extension
$tempFile = $temporaryFileService->generateTemporaryFileName('data_');
// Will create a file like: /tmp/data_abc123
```

## API Documentation

### TemporaryFileService

#### Methods

- `generateTemporaryFileName(string $prefix, ?string $ext = null): string`
  - Generate a temporary file name with optional extension
  - The file is automatically registered for cleanup
  - Returns the full path to the temporary file

- `addTemporaryFile(string $file): void`
  - Register an existing file for automatic cleanup
  - Useful for files created outside the service

- `reset(): void`
  - Manually clear the temporary file list
  - Usually called automatically by event listeners

#### Event Listeners

The service automatically cleans up temporary files on these events:
- `KernelEvents::TERMINATE` - Normal HTTP request termination
- `KernelEvents::EXCEPTION` - HTTP request exception
- `ConsoleEvents::TERMINATE` - Console command termination
- `ConsoleEvents::ERROR` - Console command error

#### Configuration

No configuration is required. The service is automatically registered and configured when the bundle is installed.

## Contributing

- Issues and PRs are welcome
- Follow PSR-12 coding style
- Please ensure all PHPUnit tests pass before submitting

## License

MIT License © tourze

## Changelog

See [CHANGELOG.md] or Git commit history for details.
