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

final class Common
{
    const LIB_DIR = '/usr/share/php';

    public static function libPsr0ClassRequire($psr0Class, $once = true)
    {
        if (!class_exists($psr0Class, false)) {
            $file = str_replace('\\', '/', $psr0Class).'.php';

            if ($once) {
                require_once self::LIB_DIR.'/'.$file;
            } else {
                require self::LIB_DIR.'/'.$file;
            }
        }
    }
}
