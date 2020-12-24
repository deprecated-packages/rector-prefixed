<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\PHPStan\Dependency\DependencyResolver;
use _PhpScoperb75b35f52b74\PHPStan\File\FileHelper;
use _PhpScoperb75b35f52b74\Psr\Cache\CacheItemPoolInterface;
use _PhpScoperb75b35f52b74\Psr\SimpleCache\CacheInterface;
use _PhpScoperb75b35f52b74\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory;
use _PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Cache\Psr16Cache;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::ENABLE_CACHE, \false);
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::CACHE_DIR, \sys_get_temp_dir() . '/_rector_cached_files');
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Caching\\', __DIR__ . '/../src');
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\Dependency\DependencyResolver::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createDependencyResolver']);
    $services->set(\_PhpScoperb75b35f52b74\PHPStan\File\FileHelper::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\DependencyInjection\PHPStanServicesFactory::class), 'createFileHelper']);
    $services->set(\_PhpScoperb75b35f52b74\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\_PhpScoperb75b35f52b74\Psr\SimpleCache\CacheInterface::class, \_PhpScoperb75b35f52b74\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->factory([\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Rector\Caching\Cache\Adapter\FilesystemAdapterFactory::class), 'create']);
    $services->set(\_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\TagAwareAdapter::class)->arg('$itemsPool', \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ref(\_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\FilesystemAdapter::class));
    $services->alias(\_PhpScoperb75b35f52b74\Psr\Cache\CacheItemPoolInterface::class, \_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
