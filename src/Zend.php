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
Common::libPsr0ClassRequire('Zend\\Loader\\AutoloaderFactory');
use Zend\Loader\AutoloaderFactory;

final class Zend
{
    protected function __construct()
    {
    }

    public static function factory($options = null)
    {
        AutoloaderFactory::factory(array(
            AutoloaderFactory\STANDARD_AUTOLOADER => $options,
        ));
    }
}
