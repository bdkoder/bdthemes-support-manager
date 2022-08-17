<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2219ea30eddda79bf0cf49c815b5edd7
{
    public static $files = array (
        '1b6e59bb6a5bac3144c054b6387275e8' => __DIR__ . '/../..' . '/includes/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Bdt\\Support\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Bdt\\Support\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2219ea30eddda79bf0cf49c815b5edd7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2219ea30eddda79bf0cf49c815b5edd7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2219ea30eddda79bf0cf49c815b5edd7::$classMap;

        }, null, ClassLoader::class);
    }
}
