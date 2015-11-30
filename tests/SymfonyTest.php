<?php

/**
 *
 */
namespace Fedora\Autoload\Test;

use Fedora\Autoload\Symfony;

class SymfonyTest extends \PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $this->assertInstanceOf(
            'Symfony\\Component\\ClassLoader\\ClassLoader',
            Symfony::getInstance(Symfony::PSR0)
        );

        $this->assertInstanceOf(
            'Symfony\\Component\\ClassLoader\\Psr4ClassLoader',
            Symfony::getInstance(Symfony::PSR4)
        );
    }

    public function testDefaultType()
    {
        $this->assertInstanceOf(
            'Symfony\\Component\\ClassLoader\\ClassLoader',
            Symfony::getInstance()
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidType()
    {
        Symfony::getInstance('exception');
    }

    public function testSingletons()
    {
        $this->assertSame(
            Symfony::getInstance(Symfony::PSR0),
            Symfony::getInstance(Symfony::PSR0)
        );

        $this->assertSame(
            Symfony::getInstance(Symfony::PSR4),
            Symfony::getInstance(Symfony::PSR4)
        );
    }
}
