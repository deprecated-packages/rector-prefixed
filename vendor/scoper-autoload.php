<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('AutoloadIncluder', false) && !interface_exists('AutoloadIncluder', false) && !trait_exists('AutoloadIncluder', false)) {
    spl_autoload_call('RectorPrefix20210318\AutoloadIncluder');
}
if (!class_exists('SomeFormType', false) && !interface_exists('SomeFormType', false) && !trait_exists('SomeFormType', false)) {
    spl_autoload_call('RectorPrefix20210318\SomeFormType');
}
if (!class_exists('SomeClass', false) && !interface_exists('SomeClass', false) && !trait_exists('SomeClass', false)) {
    spl_autoload_call('RectorPrefix20210318\SomeClass');
}
if (!class_exists('AnotherClass', false) && !interface_exists('AnotherClass', false) && !trait_exists('AnotherClass', false)) {
    spl_autoload_call('RectorPrefix20210318\AnotherClass');
}
if (!class_exists('SomeTestCase', false) && !interface_exists('SomeTestCase', false) && !trait_exists('SomeTestCase', false)) {
    spl_autoload_call('RectorPrefix20210318\SomeTestCase');
}
if (!class_exists('CheckoutEntityFactory', false) && !interface_exists('CheckoutEntityFactory', false) && !trait_exists('CheckoutEntityFactory', false)) {
    spl_autoload_call('RectorPrefix20210318\CheckoutEntityFactory');
}
if (!class_exists('Composer\InstalledVersions', false) && !interface_exists('Composer\InstalledVersions', false) && !trait_exists('Composer\InstalledVersions', false)) {
    spl_autoload_call('RectorPrefix20210318\Composer\InstalledVersions');
}
if (!class_exists('ComposerAutoloaderInit47680e1d9784313339aae87f4e94c6af', false) && !interface_exists('ComposerAutoloaderInit47680e1d9784313339aae87f4e94c6af', false) && !trait_exists('ComposerAutoloaderInit47680e1d9784313339aae87f4e94c6af', false)) {
    spl_autoload_call('RectorPrefix20210318\ComposerAutoloaderInit47680e1d9784313339aae87f4e94c6af');
}
if (!class_exists('Doctrine\Inflector\Inflector', false) && !interface_exists('Doctrine\Inflector\Inflector', false) && !trait_exists('Doctrine\Inflector\Inflector', false)) {
    spl_autoload_call('RectorPrefix20210318\Doctrine\Inflector\Inflector');
}
if (!class_exists('Symfony\Component\Console\Style\SymfonyStyle', false) && !interface_exists('Symfony\Component\Console\Style\SymfonyStyle', false) && !trait_exists('Symfony\Component\Console\Style\SymfonyStyle', false)) {
    spl_autoload_call('RectorPrefix20210318\Symfony\Component\Console\Style\SymfonyStyle');
}
if (!class_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !interface_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !trait_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false)) {
    spl_autoload_call('RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator');
}
if (!class_exists('Normalizer', false) && !interface_exists('Normalizer', false) && !trait_exists('Normalizer', false)) {
    spl_autoload_call('RectorPrefix20210318\Normalizer');
}
if (!class_exists('JsonException', false) && !interface_exists('JsonException', false) && !trait_exists('JsonException', false)) {
    spl_autoload_call('RectorPrefix20210318\JsonException');
}
if (!class_exists('Attribute', false) && !interface_exists('Attribute', false) && !trait_exists('Attribute', false)) {
    spl_autoload_call('RectorPrefix20210318\Attribute');
}
if (!class_exists('Stringable', false) && !interface_exists('Stringable', false) && !trait_exists('Stringable', false)) {
    spl_autoload_call('RectorPrefix20210318\Stringable');
}
if (!class_exists('UnhandledMatchError', false) && !interface_exists('UnhandledMatchError', false) && !trait_exists('UnhandledMatchError', false)) {
    spl_autoload_call('RectorPrefix20210318\UnhandledMatchError');
}
if (!class_exists('ValueError', false) && !interface_exists('ValueError', false) && !trait_exists('ValueError', false)) {
    spl_autoload_call('RectorPrefix20210318\ValueError');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('composerRequire47680e1d9784313339aae87f4e94c6af')) {
    function composerRequire47680e1d9784313339aae87f4e94c6af() {
        return \RectorPrefix20210318\composerRequire47680e1d9784313339aae87f4e94c6af(...func_get_args());
    }
}
if (!function_exists('parseArgs')) {
    function parseArgs() {
        return \RectorPrefix20210318\parseArgs(...func_get_args());
    }
}
if (!function_exists('showHelp')) {
    function showHelp() {
        return \RectorPrefix20210318\showHelp(...func_get_args());
    }
}
if (!function_exists('formatErrorMessage')) {
    function formatErrorMessage() {
        return \RectorPrefix20210318\formatErrorMessage(...func_get_args());
    }
}
if (!function_exists('resolveNodes')) {
    function resolveNodes() {
        return \RectorPrefix20210318\resolveNodes(...func_get_args());
    }
}
if (!function_exists('resolveMacros')) {
    function resolveMacros() {
        return \RectorPrefix20210318\resolveMacros(...func_get_args());
    }
}
if (!function_exists('resolveStackAccess')) {
    function resolveStackAccess() {
        return \RectorPrefix20210318\resolveStackAccess(...func_get_args());
    }
}
if (!function_exists('execCmd')) {
    function execCmd() {
        return \RectorPrefix20210318\execCmd(...func_get_args());
    }
}
if (!function_exists('removeTrailingWhitespace')) {
    function removeTrailingWhitespace() {
        return \RectorPrefix20210318\removeTrailingWhitespace(...func_get_args());
    }
}
if (!function_exists('ensureDirExists')) {
    function ensureDirExists() {
        return \RectorPrefix20210318\ensureDirExists(...func_get_args());
    }
}
if (!function_exists('magicSplit')) {
    function magicSplit() {
        return \RectorPrefix20210318\magicSplit(...func_get_args());
    }
}
if (!function_exists('assertArgs')) {
    function assertArgs() {
        return \RectorPrefix20210318\assertArgs(...func_get_args());
    }
}
if (!function_exists('regex')) {
    function regex() {
        return \RectorPrefix20210318\regex(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \RectorPrefix20210318\setproctitle(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \RectorPrefix20210318\includeIfExists(...func_get_args());
    }
}
if (!function_exists('dump')) {
    function dump() {
        return \RectorPrefix20210318\dump(...func_get_args());
    }
}
if (!function_exists('dd')) {
    function dd() {
        return \RectorPrefix20210318\dd(...func_get_args());
    }
}

return $loader;
