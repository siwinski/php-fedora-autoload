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

require_once __DIR__.'/Common.php';

final class Dependencies
{
    public static function required($dependencies, $prefix = Common::LIB_DIR)
    {
        foreach ((array) $dependencies as $dependency) {
            Common::prefixRequire($dependency, $prefix);
        }
    }

    public static function optional($dependencies, $prefix = Common::LIB_DIR)
    {
        foreach ((array) $dependencies as $dependency) {
            Common::prefixInclude($dependency, $prefix);
        }
    }
}
