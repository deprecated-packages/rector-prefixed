<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\PHPStan\Dependency\DependencyResolver;
use _PhpScoper0a6b37af0871\PHPStan\File\FileHelper;
use _PhpScoper0a6b37af0871\Psr\Cache\CacheItemPoolInterface;
use _PhpScoper0a6b37af0871\Psr\SimpleCache\CacheInterface;
use _PhpScoper0a6b37af0871\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\Option;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\Cache\Psr16Cache;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\Option::ENABLE_CACHE, \false);
    $parameters->set(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\Option::CACHE_DIR, \sys_get_temp_dir() . '/_rector_cached_files');
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Caching\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\Dependency\DependencyResolver::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDependencyResolver']);
    $services->set(\_PhpScoper0a6b37af0871\PHPStan\File\FileHelper::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createFileHelper']);
    $services->set(\_PhpScoper0a6b37af0871\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\_PhpScoper0a6b37af0871\Psr\SimpleCache\CacheInterface::class, \_PhpScoper0a6b37af0871\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\_PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->factory([\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory::class), 'create']);
    $services->set(\_PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\TagAwareAdapter::class)->arg('$itemsPool', \_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\FilesystemAdapter::class));
    $services->alias(\_PhpScoper0a6b37af0871\Psr\Cache\CacheItemPoolInterface::class, \_PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\_PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \_PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
