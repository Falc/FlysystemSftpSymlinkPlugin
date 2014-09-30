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
 * Sftp DeleteSymlink plugin.
 *
 * Implements a deleteSymlink($symlink) method for Filesystem instances using SftpAdapter.
 */
class DeleteSymlink implements PluginInterface
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
        return 'deleteSymlink';
    }

    /**
     * Method logic.
     *
     * Deletes a symlink.
     *
     * @param   string  $symlink    Symlink name.
     * @return  boolean             True on success. False on failure.
     */
    public function handle($symlink)
    {
        $connection = $this->filesystem->getAdapter()->getConnection();
        $output = $connection->exec('if [ -h '.$symlink.' ]; then echo 1; else echo 0; fi');

        $success = (trim($output) === '1');

        if (!$success) {
            return false;
        }

        $output = $connection->exec('rm '.$symlink);
        return empty($output);
    }
}
