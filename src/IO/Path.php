<?php

namespace Curve\Core\IO;

use \InvalidArgumentException;

/**
 * Static utilities for manipulating file system paths
 * @package Curve\Hero\IO
 */
class Path
{
    /**
     * Combines two strings into a path
     * @param string $path1 the first path to combine
     * @param string $path2 the second path to combine
     * @return string The combined paths.  If one of the paths is a zero-length string this
     *                method returns the other path. If $path2 is an absolute path this
     *                method returns $path2.
    */
    public static function combine($path1, $path2)
    {
        // Handle zero-length strings
        if (!$path1) {
            return $path2;
        } elseif (!$path2) {
            return $path1;
        }

        // Handle absolute second path
        if (strpos($path2, DIRECTORY_SEPARATOR) === 0) {
            return $path2;
        }

        // Ensure $path1 ends with a directory separator
        if (substr($path1, -strlen(DIRECTORY_SEPARATOR)) !== DIRECTORY_SEPARATOR) {
            $path1 = $path1.DIRECTORY_SEPARATOR;
        }

        return $path1.$path2;
    }

    /**
     * Converts a filename which may contain dangerous characters into a safe version.
     * While it is true that Unix file systems only restrict NUL and / in file name, this
     * function goes further and replaces all characters including NUL, space, ", ', &, /, \, ?, *, and #
     *
     * @param string $filename the filename whose invalid characters will be replaced
     * @param string $replacement the string used in place of invalid characters
     * @return string the filename with all invalid characters replaced
     */
    public static function replaceDangerousFileNameChars($filename, $replacement)
    {
        return str_replace(array("\0", " ", '"', "'", "&", "/", "\\", "?", "#", "*"), $replacement, $filename);
    }

    /**
     * Creates a temporary subdirectory below the system's subdirectory and returns
     * the path to the temporary directory
     * $param string $basePath the base directory to create the temporary directory in
     * @return string the path of the temporary directory or null on failure
     */
    public static function createTempDir($basePath = '')
    {
        if (!$basePath) {
            $basePath = sys_get_temp_dir();
        }

        $tempfile = tempnam($basePath, '');
        if (file_exists($tempfile)) {
            unlink($tempfile);
        }
        mkdir($tempfile);
        if (is_dir($tempfile)) {
            return $tempfile;
        }
        return null;
    }

    /**
     * Recursively removes a directory and all of the subdirectories and files within it
     * @param string $dir the directory to delete
     * @throws \InvalidArgumentException if $dir is not a directory
     */
    public static function recursiveRemoveDir($dir)
    {
        if (!is_dir($dir)) {
            throw new InvalidArgumentException("$dir is not a directory");
        }

        foreach (glob("{$dir}/*") as $file) {
            if (is_dir($file)) {
                self::recursiveRemoveDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dir);
    }
}
