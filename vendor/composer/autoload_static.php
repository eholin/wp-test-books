<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4cbee35c3aba3604066c8a2882f12542
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4cbee35c3aba3604066c8a2882f12542::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4cbee35c3aba3604066c8a2882f12542::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
