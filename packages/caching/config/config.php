<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2;

use PHPStan\Dependency\DependencyResolver;
use PHPStan\File\FileHelper;
use _PhpScoperf18a0c41e2d2\Psr\Cache\CacheItemPoolInterface;
use _PhpScoperf18a0c41e2d2\Psr\SimpleCache\CacheInterface;
use Rector\Caching\Cache\Adapter\FilesystemAdapterFactory;
use Rector\Core\Configuration\Option;
use Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Psr16Cache;
use _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::ENABLE_CACHE, \false);
    $parameters->set(\Rector\Core\Configuration\Option::CACHE_DIR, \sys_get_temp_dir() . '/_rector_cached_files');
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Caching\\', __DIR__ . '/../src');
    $services->set(\PHPStan\Dependency\DependencyResolver::class)->factory([\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDependencyResolver']);
    $services->set(\PHPStan\File\FileHelper::class)->factory([\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createFileHelper']);
    $services->set(\_PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\_PhpScoperf18a0c41e2d2\Psr\SimpleCache\CacheInterface::class, \_PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\_PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->factory([\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory::class), 'create']);
    $services->set(\_PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Adapter\TagAwareAdapter::class)->arg('$itemsPool', \_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Adapter\FilesystemAdapter::class));
    $services->alias(\_PhpScoperf18a0c41e2d2\Psr\Cache\CacheItemPoolInterface::class, \_PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\_PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \_PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
