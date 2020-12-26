<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use PHPStan\Dependency\DependencyResolver;
use PHPStan\File\FileHelper;
use RectorPrefix2020DecSat\Psr\Cache\CacheItemPoolInterface;
use RectorPrefix2020DecSat\Psr\SimpleCache\CacheInterface;
use Rector\Caching\Cache\Adapter\FilesystemAdapterFactory;
use Rector\Core\Configuration\Option;
use Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use RectorPrefix2020DecSat\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use RectorPrefix2020DecSat\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use RectorPrefix2020DecSat\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use RectorPrefix2020DecSat\Symfony\Component\Cache\Psr16Cache;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::ENABLE_CACHE, \false);
    $parameters->set(\Rector\Core\Configuration\Option::CACHE_DIR, \sys_get_temp_dir() . '/_rector_cached_files');
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Caching\\', __DIR__ . '/../src');
    $services->set(\PHPStan\Dependency\DependencyResolver::class)->factory([\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDependencyResolver']);
    $services->set(\PHPStan\File\FileHelper::class)->factory([\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createFileHelper']);
    $services->set(\RectorPrefix2020DecSat\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\RectorPrefix2020DecSat\Psr\SimpleCache\CacheInterface::class, \RectorPrefix2020DecSat\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\RectorPrefix2020DecSat\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->factory([\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory::class), 'create']);
    $services->set(\RectorPrefix2020DecSat\Symfony\Component\Cache\Adapter\TagAwareAdapter::class)->arg('$itemsPool', \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\RectorPrefix2020DecSat\Symfony\Component\Cache\Adapter\FilesystemAdapter::class));
    $services->alias(\RectorPrefix2020DecSat\Psr\Cache\CacheItemPoolInterface::class, \RectorPrefix2020DecSat\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\RectorPrefix2020DecSat\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \RectorPrefix2020DecSat\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
