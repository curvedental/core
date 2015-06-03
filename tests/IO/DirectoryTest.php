<?php

namespace Curve\Core\IO;

class DirectoryTest extends \PHPUnit_Framework_TestCase
{
    public function testWhenPathIsNotADirectoryThenThrowsException()
    {
        try {
            new Directory('/this_should_not_be_a_valid_path', false);
            $this->fail();
        } catch (\InvalidArgumentException $exception) {
        }
    }

    public function testWhenPathIsAFileThenThrowsException()
    {
        $tempFile = tempnam(sys_get_temp_dir(), '');
        try {
            new Directory($tempFile, false);
            $this->fail();
        } catch (\InvalidArgumentException $exception) {
        }
        unlink($tempFile);
    }

    public function testRecursivelyDeletesDirectoriesOnDestruction()
    {
        $tempDir = Path::createTempDir();
        Path::createTempDir($tempDir);

        $directory = new Directory($tempDir, true);
        unset($directory);

        $this->assertFalse(is_dir($tempDir));
    }
}
