<?php
/**
 * This file is part of FlysystemSftpSymlinkPlugin.
 *
 * @author      Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @copyright   2014 Aitor García Martínez (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Flysystem\Plugin\Symlink\Sftp;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;

/**
 * Sftp Symlink plugin.
 *
 * Implements a symlink($symlink, $target) method for Filesystem instances using SftpAdapter.
 */
class Symlink implements PluginInterface
{
    /**
     * FilesystemInterface instance.
     *
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Sets the Filesystem instance.
     *
     * @param FilesystemInterface $filesystem
     */
    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Gets the method name.
     *
     * @return string
     */
    public function getMethod()
    {
        return 'symlink';
    }

    /**
     * Method logic.
     *
     * Creates a symlink.
     *
     * @param   string  $target     Symlink target.
     * @param   string  $symlink    Symlink name.
     * @return  boolean             True on success. False on failure.
     */
    public function handle($target, $symlink)
    {
        $pathPrefix = $this->filesystem->getAdapter()->getRoot();
        $target = $pathPrefix.ltrim($target, '/');
        $symlink = $pathPrefix.ltrim($symlink, '/');

        $connection = $this->filesystem->getAdapter()->getConnection();
        return $connection->symlink($target, $symlink);
    }
}
