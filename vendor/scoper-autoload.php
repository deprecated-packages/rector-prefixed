<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('AutoloadIncluder', false) && !interface_exists('AutoloadIncluder', false) && !trait_exists('AutoloadIncluder', false)) {
    spl_autoload_call('RectorPrefix20210422\AutoloadIncluder');
}
if (!class_exists('SomeFormType', false) && !interface_exists('SomeFormType', false) && !trait_exists('SomeFormType', false)) {
    spl_autoload_call('RectorPrefix20210422\SomeFormType');
}
if (!class_exists('SomeClass', false) && !interface_exists('SomeClass', false) && !trait_exists('SomeClass', false)) {
    spl_autoload_call('RectorPrefix20210422\SomeClass');
}
if (!class_exists('AnotherClass', false) && !interface_exists('AnotherClass', false) && !trait_exists('AnotherClass', false)) {
    spl_autoload_call('RectorPrefix20210422\AnotherClass');
}
if (!class_exists('SomeTestCase', false) && !interface_exists('SomeTestCase', false) && !trait_exists('SomeTestCase', false)) {
    spl_autoload_call('RectorPrefix20210422\SomeTestCase');
}
if (!class_exists('CheckoutEntityFactory', false) && !interface_exists('CheckoutEntityFactory', false) && !trait_exists('CheckoutEntityFactory', false)) {
    spl_autoload_call('RectorPrefix20210422\CheckoutEntityFactory');
}
if (!class_exists('Composer\InstalledVersions', false) && !interface_exists('Composer\InstalledVersions', false) && !trait_exists('Composer\InstalledVersions', false)) {
    spl_autoload_call('RectorPrefix20210422\Composer\InstalledVersions');
}
if (!class_exists('ComposerAutoloaderInit1063365ac05c70382e2becc3e3367650', false) && !interface_exists('ComposerAutoloaderInit1063365ac05c70382e2becc3e3367650', false) && !trait_exists('ComposerAutoloaderInit1063365ac05c70382e2becc3e3367650', false)) {
    spl_autoload_call('RectorPrefix20210422\ComposerAutoloaderInit1063365ac05c70382e2becc3e3367650');
}
if (!class_exists('Doctrine\Inflector\Inflector', false) && !interface_exists('Doctrine\Inflector\Inflector', false) && !trait_exists('Doctrine\Inflector\Inflector', false)) {
    spl_autoload_call('RectorPrefix20210422\Doctrine\Inflector\Inflector');
}
if (!class_exists('Symfony\Component\Console\Style\SymfonyStyle', false) && !interface_exists('Symfony\Component\Console\Style\SymfonyStyle', false) && !trait_exists('Symfony\Component\Console\Style\SymfonyStyle', false)) {
    spl_autoload_call('RectorPrefix20210422\Symfony\Component\Console\Style\SymfonyStyle');
}
if (!class_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !interface_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !trait_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false)) {
    spl_autoload_call('RectorPrefix20210422\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator');
}
if (!class_exists('Normalizer', false) && !interface_exists('Normalizer', false) && !trait_exists('Normalizer', false)) {
    spl_autoload_call('RectorPrefix20210422\Normalizer');
}
if (!class_exists('JsonException', false) && !interface_exists('JsonException', false) && !trait_exists('JsonException', false)) {
    spl_autoload_call('RectorPrefix20210422\JsonException');
}
if (!class_exists('Attribute', false) && !interface_exists('Attribute', false) && !trait_exists('Attribute', false)) {
    spl_autoload_call('RectorPrefix20210422\Attribute');
}
if (!class_exists('Stringable', false) && !interface_exists('Stringable', false) && !trait_exists('Stringable', false)) {
    spl_autoload_call('RectorPrefix20210422\Stringable');
}
if (!class_exists('UnhandledMatchError', false) && !interface_exists('UnhandledMatchError', false) && !trait_exists('UnhandledMatchError', false)) {
    spl_autoload_call('RectorPrefix20210422\UnhandledMatchError');
}
if (!class_exists('ValueError', false) && !interface_exists('ValueError', false) && !trait_exists('ValueError', false)) {
    spl_autoload_call('RectorPrefix20210422\ValueError');
}
if (!class_exists('Symplify\SmartFileSystem\SmartFileInfo', false) && !interface_exists('Symplify\SmartFileSystem\SmartFileInfo', false) && !trait_exists('Symplify\SmartFileSystem\SmartFileInfo', false)) {
    spl_autoload_call('RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileInfo');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('composerRequire1063365ac05c70382e2becc3e3367650')) {
    function composerRequire1063365ac05c70382e2becc3e3367650() {
        return \RectorPrefix20210422\composerRequire1063365ac05c70382e2becc3e3367650(...func_get_args());
    }
}
if (!function_exists('parseArgs')) {
    function parseArgs() {
        return \RectorPrefix20210422\parseArgs(...func_get_args());
    }
}
if (!function_exists('showHelp')) {
    function showHelp() {
        return \RectorPrefix20210422\showHelp(...func_get_args());
    }
}
if (!function_exists('formatErrorMessage')) {
    function formatErrorMessage() {
        return \RectorPrefix20210422\formatErrorMessage(...func_get_args());
    }
}
if (!function_exists('resolveNodes')) {
    function resolveNodes() {
        return \RectorPrefix20210422\resolveNodes(...func_get_args());
    }
}
if (!function_exists('resolveMacros')) {
    function resolveMacros() {
        return \RectorPrefix20210422\resolveMacros(...func_get_args());
    }
}
if (!function_exists('resolveStackAccess')) {
    function resolveStackAccess() {
        return \RectorPrefix20210422\resolveStackAccess(...func_get_args());
    }
}
if (!function_exists('execCmd')) {
    function execCmd() {
        return \RectorPrefix20210422\execCmd(...func_get_args());
    }
}
if (!function_exists('removeTrailingWhitespace')) {
    function removeTrailingWhitespace() {
        return \RectorPrefix20210422\removeTrailingWhitespace(...func_get_args());
    }
}
if (!function_exists('ensureDirExists')) {
    function ensureDirExists() {
        return \RectorPrefix20210422\ensureDirExists(...func_get_args());
    }
}
if (!function_exists('magicSplit')) {
    function magicSplit() {
        return \RectorPrefix20210422\magicSplit(...func_get_args());
    }
}
if (!function_exists('assertArgs')) {
    function assertArgs() {
        return \RectorPrefix20210422\assertArgs(...func_get_args());
    }
}
if (!function_exists('regex')) {
    function regex() {
        return \RectorPrefix20210422\regex(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \RectorPrefix20210422\setproctitle(...func_get_args());
    }
}
if (!function_exists('trigger_deprecation')) {
    function trigger_deprecation() {
        return \RectorPrefix20210422\trigger_deprecation(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \RectorPrefix20210422\includeIfExists(...func_get_args());
    }
}
if (!function_exists('dump')) {
    function dump() {
        return \RectorPrefix20210422\dump(...func_get_args());
    }
}
if (!function_exists('dd')) {
    function dd() {
        return \RectorPrefix20210422\dd(...func_get_args());
    }
}

return $loader;
