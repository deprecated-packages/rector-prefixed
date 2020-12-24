<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Dependency\DependencyResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\File\FileHelper;
use _PhpScoper2a4e7ab1ecbc\Psr\Cache\CacheItemPoolInterface;
use _PhpScoper2a4e7ab1ecbc\Psr\SimpleCache\CacheInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Psr16Cache;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option::ENABLE_CACHE, \false);
    $parameters->set(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option::CACHE_DIR, \sys_get_temp_dir() . '/_rector_cached_files');
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Caching\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper2a4e7ab1ecbc\PHPStan\Dependency\DependencyResolver::class)->factory([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDependencyResolver']);
    $services->set(\_PhpScoper2a4e7ab1ecbc\PHPStan\File\FileHelper::class)->factory([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createFileHelper']);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\_PhpScoper2a4e7ab1ecbc\Psr\SimpleCache\CacheInterface::class, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->factory([\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper2a4e7ab1ecbc\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory::class), 'create']);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\TagAwareAdapter::class)->arg('$itemsPool', \_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\FilesystemAdapter::class));
    $services->alias(\_PhpScoper2a4e7ab1ecbc\Psr\Cache\CacheItemPoolInterface::class, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
