<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8a569114a600bd2d762814f2cc173d43
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mybasicmodule\\Controller\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mybasicmodule\\Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/controller',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8a569114a600bd2d762814f2cc173d43::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8a569114a600bd2d762814f2cc173d43::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
