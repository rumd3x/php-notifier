<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita3bef37003211e6a8e2ef66d93f0525c
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Rumd3x\\Notifier\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Rumd3x\\Notifier\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Rumd3x\\Notifier\\Abstracts\\NotifiableAbstract' => __DIR__ . '/../..' . '/src/Abstracts/NotifiableAbstract.php',
        'Rumd3x\\Notifier\\Interfaces\\NotifiableInterface' => __DIR__ . '/../..' . '/src/Interfaces/NotifiableInterface.php',
        'Rumd3x\\Notifier\\Notifiable' => __DIR__ . '/../..' . '/src/Notifiable.php',
        'Rumd3x\\Notifier\\Notification' => __DIR__ . '/../..' . '/src/Notification.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita3bef37003211e6a8e2ef66d93f0525c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita3bef37003211e6a8e2ef66d93f0525c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita3bef37003211e6a8e2ef66d93f0525c::$classMap;

        }, null, ClassLoader::class);
    }
}