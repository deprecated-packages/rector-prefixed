<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\PHPStan\Dependency\DependencyResolver;
use _PhpScoper0a2ac50786fa\PHPStan\File\FileHelper;
use _PhpScoper0a2ac50786fa\Psr\Cache\CacheItemPoolInterface;
use _PhpScoper0a2ac50786fa\Psr\SimpleCache\CacheInterface;
use _PhpScoper0a2ac50786fa\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoper0a2ac50786fa\Symfony\Component\Cache\Psr16Cache;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::ENABLE_CACHE, \false);
    $parameters->set(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::CACHE_DIR, \sys_get_temp_dir() . '/_rector_cached_files');
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Caching\\', __DIR__ . '/../src');
    $services->set(\_PhpScoper0a2ac50786fa\PHPStan\Dependency\DependencyResolver::class)->factory([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDependencyResolver']);
    $services->set(\_PhpScoper0a2ac50786fa\PHPStan\File\FileHelper::class)->factory([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createFileHelper']);
    $services->set(\_PhpScoper0a2ac50786fa\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\_PhpScoper0a2ac50786fa\Psr\SimpleCache\CacheInterface::class, \_PhpScoper0a2ac50786fa\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\_PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->factory([\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a2ac50786fa\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory::class), 'create']);
    $services->set(\_PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\TagAwareAdapter::class)->arg('$itemsPool', \_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\FilesystemAdapter::class));
    $services->alias(\_PhpScoper0a2ac50786fa\Psr\Cache\CacheItemPoolInterface::class, \_PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\_PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \_PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
