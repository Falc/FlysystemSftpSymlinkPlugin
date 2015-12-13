# Flysystem Sftp Symlink Plugin

## Requirements

+ [Flysystem](http://flysystem.thephpleague.com/) >= 1.0.0
+ [flysystem-sftp](https://github.com/thephpleague/flysystem-sftp) >= 1.0.0

## Installation

Using composer:

```
composer require falc/flysystem-sftp-symlink-plugin
```

Or add it manually:

```json
{
    "require": {
        "falc/flysystem-sftp-symlink-plugin": "1.*"
    }
}
```

## Usage

This plugin requires a `Filesystem` instance using the [Sftp adapter](http://flysystem.thephpleague.com/adapter/sftp/).

```php
use Falc\Flysystem\Plugin\Symlink\Sftp as SftpSymlinkPlugin;
use League\Flysystem\Adapter\Sftp as SftpAdapter;
use League\Flysystem\Filesystem;

$filesystem = new Filesystem(new SftpAdapter(array(
    'host' => 'example.com',
    'port' => 22,
    'username' => 'username',
    'password' => 'password',
    'privateKey' => 'path/to/or/contents/of/privatekey',
    'root' => '/',
    'timeout' => 10
)));
```

### Symlink

Use `symlink($target, $symlink)` to create a symlink.

```php
$filesystem->addPlugin(new SftpSymlinkPlugin\Symlink());

$success = $filesystem->symlink('/tmp/some/target', '/tmp/symlink');
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

### Full and relative paths

The above examples show how to create symlinks using `/` as root and full paths. But it is possible to use relative paths too.

```php
use Falc\Flysystem\Plugin\Symlink\Sftp as SftpSymlinkPlugin;
use League\Flysystem\Adapter\Sftp as SftpAdapter;
use League\Flysystem\Filesystem;

$filesystem = new Filesystem(new SftpAdapter(array(
    'host' => 'example.com',
    'port' => 22,
    'username' => 'username',
    'password' => 'password',
    'privateKey' => 'path/to/or/contents/of/privatekey',
    'root' => '/home/falc',
    'timeout' => 10
)));

$filesystem->addPlugin(new SftpSymlinkPlugin\Symlink());
$filesystem->addPlugin(new SftpSymlinkPlugin\IsSymlink());
$filesystem->addPlugin(new SftpSymlinkPlugin\DeleteSymlink());

// Result: /home/falc/flytest -> /home/falc/projects/cli/flytest
$filesystem->symlink('projects/cli/flytest', 'flytest');

// It is possible to check it or delete it in the same way:
$isSymlink = $filesystem->isSymlink('flytest');
$filesystem->deleteSymlink('flytest');
```
