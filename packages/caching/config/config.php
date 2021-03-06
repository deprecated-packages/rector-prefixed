<?php

declare (strict_types=1);
namespace RectorPrefix20210306;

use PHPStan\Dependency\DependencyResolver;
use PHPStan\File\FileHelper;
use RectorPrefix20210306\Psr\Cache\CacheItemPoolInterface;
use RectorPrefix20210306\Psr\SimpleCache\CacheInterface;
use Rector\Caching\Cache\Adapter\FilesystemAdapterFactory;
use Rector\Core\Configuration\Option;
use Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use RectorPrefix20210306\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use RectorPrefix20210306\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use RectorPrefix20210306\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use RectorPrefix20210306\Symfony\Component\Cache\Psr16Cache;
use RectorPrefix20210306\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function RectorPrefix20210306\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\RectorPrefix20210306\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::ENABLE_CACHE, \false);
    $parameters->set(\Rector\Core\Configuration\Option::CACHE_DIR, \sys_get_temp_dir() . '/_rector_cached_files');
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Caching\\', __DIR__ . '/../src');
    $services->set(\PHPStan\Dependency\DependencyResolver::class)->factory([\RectorPrefix20210306\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDependencyResolver']);
    $services->set(\PHPStan\File\FileHelper::class)->factory([\RectorPrefix20210306\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createFileHelper']);
    $services->set(\RectorPrefix20210306\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\RectorPrefix20210306\Psr\SimpleCache\CacheInterface::class, \RectorPrefix20210306\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\RectorPrefix20210306\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->factory([\RectorPrefix20210306\Symfony\Component\DependencyInjection\Loader\Configurator\service(\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory::class), 'create']);
    $services->set(\RectorPrefix20210306\Symfony\Component\Cache\Adapter\TagAwareAdapter::class)->arg('$itemsPool', \RectorPrefix20210306\Symfony\Component\DependencyInjection\Loader\Configurator\service(\RectorPrefix20210306\Symfony\Component\Cache\Adapter\FilesystemAdapter::class));
    $services->alias(\RectorPrefix20210306\Psr\Cache\CacheItemPoolInterface::class, \RectorPrefix20210306\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\RectorPrefix20210306\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \RectorPrefix20210306\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
