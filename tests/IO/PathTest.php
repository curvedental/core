<?php

namespace Curve\Core\IO;

class PathTest extends \PHPUnit_Framework_TestCase
{
    public function testFirstPathReturnedWhenSecondPathZeroLength()
    {
        $result = Path::combine('/tmp/', '');
        $this->assertSame('/tmp/', $result);
    }

    public function testSecondPathReturnedWhenFirstPathZeroLength()
    {
        $result = Path::combine('', '/tmp/');
        $this->assertSame('/tmp/', $result);
    }

    public function testSecondPathReturnedWhenItIsAbsolute()
    {
        $result = Path::combine('/path1/', '/path2/');
        $this->assertSame('/path2/', $result);
    }

    public function testDirectorySeparatorNotAddedIfFirstPathEndsWithSeparator()
    {
        $result = Path::combine('/path1/', 'path2/');
        $this->assertSame('/path1/path2/', $result);
    }

    public function testDirectorySeparatorAddedIfFirstPathDoesNotEndWithSeparator()
    {
        $result = Path::combine('/path1', 'path2/');
        $this->assertSame('/path1/path2/', $result);
    }

    public function testDangerousFileNameCharactersReplaced()
    {
        $result = Path::replaceDangerousFileNameChars("a\0b c\"d'e&f/g\\h?i*j#k", "_");
        $this->assertSame('a_b_c_d_e_f_g_h_i_j_k', $result);
    }
}
