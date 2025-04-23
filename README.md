# symfony-temp-file-bundle

[![Latest Stable Version](https://img.shields.io/packagist/v/tourze/symfony-temp-file-bundle.svg)](https://packagist.org/packages/tourze/symfony-temp-file-bundle)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## Introduction

`symfony-temp-file-bundle` is a Symfony bundle for centralized management and automatic cleanup of temporary files. It ensures that temporary files generated during HTTP requests or console commands are automatically deleted at the end of the process, reducing the risk of leftover temp files.

## Features

- Unified management of temporary file creation and deletion
- Automatic cleanup at the end of HTTP requests and console commands
- Simple and easy-to-use API
- Seamless integration, minimal configuration required

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
'tempFile = $temporaryFileService->generateTemporaryFileName('prefix_', 'txt');
file_put_contents($tempFile, 'hello world');
// The temp file will be automatically deleted at the end of the request or command
```

### Register an Existing Temp File for Auto-Cleanup

```php
$temporaryFileService->addTemporaryFile($filePath);
```

## Documentation

- All generated or registered temp files are automatically cleaned up at the end of HTTP requests or console commands.
- Listens to multiple events: `KernelEvents::TERMINATE`, `KernelEvents::EXCEPTION`, `ConsoleEvents::TERMINATE`, `ConsoleEvents::ERROR`.
- No manual cleanup required, greatly reduces resource leakage risk.

## Contributing

- Issues and PRs are welcome
- Follow PSR-12 coding style
- Please ensure all PHPUnit tests pass before submitting

## License

MIT License © tourze

## Changelog

See [CHANGELOG.md] or Git commit history for details.
