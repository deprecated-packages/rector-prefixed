<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\PHPStan\Dependency\DependencyResolver;
use _PhpScopere8e811afab72\PHPStan\File\FileHelper;
use _PhpScopere8e811afab72\Psr\Cache\CacheItemPoolInterface;
use _PhpScopere8e811afab72\Psr\SimpleCache\CacheInterface;
use _PhpScopere8e811afab72\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScopere8e811afab72\Symfony\Component\Cache\Psr16Cache;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::ENABLE_CACHE, \false);
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::CACHE_DIR, \sys_get_temp_dir() . '/_rector_cached_files');
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Caching\\', __DIR__ . '/../src');
    $services->set(\_PhpScopere8e811afab72\PHPStan\Dependency\DependencyResolver::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDependencyResolver']);
    $services->set(\_PhpScopere8e811afab72\PHPStan\File\FileHelper::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createFileHelper']);
    $services->set(\_PhpScopere8e811afab72\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\_PhpScopere8e811afab72\Psr\SimpleCache\CacheInterface::class, \_PhpScopere8e811afab72\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\_PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->factory([\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory::class), 'create']);
    $services->set(\_PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\TagAwareAdapter::class)->arg('$itemsPool', \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\FilesystemAdapter::class));
    $services->alias(\_PhpScopere8e811afab72\Psr\Cache\CacheItemPoolInterface::class, \_PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\_PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \_PhpScopere8e811afab72\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
