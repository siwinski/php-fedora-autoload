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

use Fedora\Autoload\Common;
use Zend\Loader\AutoloaderFactory;

require_once __DIR__.'/Common.php';
Common::prefixPsr0ClassRequire('Zend\\Loader\\AutoloaderFactory');

final class Zend
{
    private function __construct()
    {
    }

    public static function factory($options = null)
    {
        AutoloaderFactory::factory(array(
            AutoloaderFactory\STANDARD_AUTOLOADER => $options,
        ));
    }
}
