<?php

namespace Curve\Core\IO;

/**
 * A resource wrapper for a directory path which provides for automatic
 * recursive removal of the directory on destruction
 */
class Directory
{
    private $path;
    private $removeOnDestruct;

    /**
     * @param string $path path to the directory to be wrapped
     * @param boolean $removeOnDestruct flag indicating if directory should be removed on destruction
     */
    public function __construct($path, $removeOnDestruct)
    {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException("$path is not a directory");
        }
        $this->path = $path;
        $this->removeOnDestruct = $removeOnDestruct;
    }

    /**
     * Makes a best effort to remove $path if it still exists
     */
    public function __destruct()
    {
        if ($this->removeOnDestruct && is_dir($this->path)) {
            try {
                Path::recursiveRemoveDir($this->path);
            } catch (\Exception $exception) {
                // Do nothing
            }
        }
    }

    public function getPath()
    {
        return $this->path;
    }
}
