<?php
/**
 * This file is part of the Fedora Autoload package.
 *
 * (c) Shawn Iwinski <shawn@iwin.ski>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Fedora\Autoload;

require_once __DIR__.'/Common.php';

use Symfony\Component\ClassLoader\ClassLoader;
use Symfony\Component\ClassLoader\Psr4ClassLoader;

final class Symfony
{
    const PSR0 = 'psr0';
    const PSR4 = 'psr4';

    private static $instances = array();

    private function __construct()
    {
    }

    public static function getInstance($type = self::PSR0)
    {
        if (!isset(static::$instances[$type])) {
            switch ($type) {
                case self::PSR0:
                    Common::prefixPsr0ClassRequire('Symfony\\Component\\ClassLoader\\ClassLoader');
                    static::$instances[$type] = new ClassLoader();
                    break;
                case self::PSR4:
                    Common::prefixPsr0ClassRequire('Symfony\\Component\\ClassLoader\\Psr4ClassLoader');
                    static::$instances[$type] = new Psr4ClassLoader();
                    break;
                default:
                    throw new \InvalidArgumentException('Invalid type');
            }

            static::$instances[$type]->register();
        }

        return static::$instances[$type];
    }
}
