<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use PHPStan\Dependency\DependencyResolver;
use PHPStan\File\FileHelper;
use _PhpScoper88fe6e0ad041\Psr\Cache\CacheItemPoolInterface;
use _PhpScoper88fe6e0ad041\Psr\SimpleCache\CacheInterface;
use Rector\Caching\Cache\Adapter\FilesystemAdapterFactory;
use Rector\Core\Configuration\Option;
use Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoper88fe6e0ad041\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoper88fe6e0ad041\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoper88fe6e0ad041\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoper88fe6e0ad041\Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::ENABLE_CACHE, \false);
    $parameters->set(\Rector\Core\Configuration\Option::CACHE_DIR, \sys_get_temp_dir() . '/_rector_cached_files');
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Caching\\', __DIR__ . '/../src');
    $services->set(\PHPStan\Dependency\DependencyResolver::class)->factory([\_PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDependencyResolver']);
    $services->set(\PHPStan\File\FileHelper::class)->factory([\_PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createFileHelper']);
    $services->set(\_PhpScoper88fe6e0ad041\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\_PhpScoper88fe6e0ad041\Psr\SimpleCache\CacheInterface::class, \_PhpScoper88fe6e0ad041\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\_PhpScoper88fe6e0ad041\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->factory([\_PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory::class), 'create']);
    $services->set(\_PhpScoper88fe6e0ad041\Symfony\Component\Cache\Adapter\TagAwareAdapter::class)->arg('$itemsPool', \_PhpScoper88fe6e0ad041\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoper88fe6e0ad041\Symfony\Component\Cache\Adapter\FilesystemAdapter::class));
    $services->alias(\_PhpScoper88fe6e0ad041\Psr\Cache\CacheItemPoolInterface::class, \_PhpScoper88fe6e0ad041\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\_PhpScoper88fe6e0ad041\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \_PhpScoper88fe6e0ad041\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
