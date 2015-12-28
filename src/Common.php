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

    public static function prefixPsr0ClassRequire($psr0Class, $prefix = self::LIB_DIR, $once = true)
    {
        if (!class_exists($psr0Class, false)) {
            self::prefixRequire(
                str_replace('\\', '/', $psr0Class).'.php',
                $prefix,
                $once
            );
        }
    }

    public static function prefixRequire($file, $prefix = self::LIB_DIR, $once = true)
    {
        if ($once) {
            return require_once $prefix.'/'.$file;
        } else {
            return require $prefix.'/'.$file;
        }
    }

    public static function prefixInclude($file, $prefix = self::LIB_DIR, $once = true)
    {
        if ($once) {
            return @include_once $prefix.'/'.$file;
        } else {
            return @include $prefix.'/'.$file;
        }
    }

    public static function requiredDependencies($dependencies, $prefix = self::LIB_DIR)
    {
        foreach ((array) $dependencies as $dependency) {
            self::prefixRequire($dependency, $prefix);
        }
    }

    public static function optionalDependencies($dependencies, $prefix = self::LIB_DIR)
    {
        foreach ((array) $dependencies as $dependency) {
            self::prefixInclude($dependency, $prefix);
        }
    }
}
