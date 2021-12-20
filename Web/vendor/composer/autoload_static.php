<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc25021264c764a2c8159db8b148d285a
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Foot\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Foot\\' => 
        array (
            0 => __DIR__ . '/../..' . '/class',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc25021264c764a2c8159db8b148d285a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc25021264c764a2c8159db8b148d285a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc25021264c764a2c8159db8b148d285a::$classMap;

        }, null, ClassLoader::class);
    }
}
