<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit266fd748d4af5d4912bab33dd595f0f7
{
    public static $files = array (
        'a2c48002d05f7782d8b603bd2bcb5252' => __DIR__ . '/..' . '/johnbillion/extended-cpts/extended-cpts.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'StoutLogic\\AcfBuilder\\' => 22,
        ),
        'L' => 
        array (
            'League\\Plates\\' => 14,
        ),
        'D' => 
        array (
            'Doctrine\\Instantiator\\' => 22,
            'Doctrine\\Common\\Inflector\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'StoutLogic\\AcfBuilder\\' => 
        array (
            0 => __DIR__ . '/..' . '/stoutlogic/acf-builder/src',
        ),
        'League\\Plates\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/plates/src',
        ),
        'Doctrine\\Instantiator\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/instantiator/src/Doctrine/Instantiator',
        ),
        'Doctrine\\Common\\Inflector\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/inflector/lib/Doctrine/Common/Inflector',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit266fd748d4af5d4912bab33dd595f0f7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit266fd748d4af5d4912bab33dd595f0f7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
