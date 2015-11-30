<?php

/**
 *
 */
namespace Fedora\Autoload\Test;

use Fedora\Autoload\Common;

class CommonTest extends \PHPUnit_Framework_TestCase
{
    public function testLibDirExists()
    {
        $this->assertFileExists(Common::LIB_DIR);
    }
}
