# Flysystem Sftp Symlink Plugin

## Requirements

+ [Flysystem](http://flysystem.thephpleague.com/) >= 0.5.0
+ [phpseclib](https://github.com/phpseclib/phpseclib) >= 0.3.5

## Installation

Using composer:

```json
{
    "require": {
        "falc/flysystem-sftp-symlink-plugin": "dev-master"
    }
}
```

## Usage

This plugin requires a `Filesystem` instance using the [Sftp adapter](http://flysystem.thephpleague.com/adapter/sftp/).

```php
<?php

use Falc\Flysystem\Plugin\Symlink\Sftp as SftpSymlinkPlugin;
use League\Flysystem\Adapter\Sftp as SftpAdapter;
use League\Flysystem\Filesystem;

$filesystem = new Filesystem(new SftpAdapter(array(
    'host' => 'example.com',
    'port' => 21,
    'username' => 'username',
    'password' => 'password',
    'privateKey' => 'path/to/or/contents/of/privatekey',
    'root' => '/path/to/root',
    'timeout' => 10
)));
```

### Symlink

Use `symlink($symlink, $target)` to create a symlink.

```php
$filesystem->addPlugin(new SftpSymlinkPlugin\Symlink());

$success = $filesystem->symlink('/tmp/symlink', '/tmp/some/target');
```

### DeleteSymlink

Use `deleteSymlink($symlink)` to delete a symlink.

```php
$filesystem->addPlugin(new SftpSymlinkPlugin\DeleteSymlink());

$success = $filesystem->deleteSymlink('/tmp/symlink');
```

### IsSymlink

Use `isSymlink($filename)` to check if a file exists and is a symlink.

```php
$filesystem->addPlugin(new SftpSymlinkPlugin\IsSymlink());

$isSymlink = $filesystem->isSymlink('/tmp/symlink');
```
