<?php

declare (strict_types=1);
namespace RectorPrefix20210206\Symplify\PhpConfigPrinter\Bundle;

use RectorPrefix20210206\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210206\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use RectorPrefix20210206\Symfony\Component\HttpKernel\Bundle\Bundle;
use RectorPrefix20210206\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use RectorPrefix20210206\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use RectorPrefix20210206\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use RectorPrefix20210206\Symplify\PhpConfigPrinter\DependencyInjection\Extension\PhpConfigPrinterExtension;
use RectorPrefix20210206\Symplify\PhpConfigPrinter\Dummy\DummySymfonyVersionFeatureGuard;
use RectorPrefix20210206\Symplify\PhpConfigPrinter\Dummy\DummyYamlFileContentProvider;
/**
 * This class is dislocated in non-standard location, so it's not added by symfony/flex
 * to bundles.php and cause app to crash. See https://github.com/symplify/symplify/issues/1952#issuecomment-628765364
 */
final class PhpConfigPrinterBundle extends \RectorPrefix20210206\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\RectorPrefix20210206\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $this->registerDefaultImplementations($containerBuilder);
        $containerBuilder->addCompilerPass(new \RectorPrefix20210206\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\RectorPrefix20210206\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \RectorPrefix20210206\Symplify\PhpConfigPrinter\DependencyInjection\Extension\PhpConfigPrinterExtension();
    }
    private function registerDefaultImplementations(\RectorPrefix20210206\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // set default implementations, if none provided - for better developer experience out of the box
        if (!$containerBuilder->has(\RectorPrefix20210206\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class)) {
            $containerBuilder->autowire(\RectorPrefix20210206\Symplify\PhpConfigPrinter\Dummy\DummyYamlFileContentProvider::class)->setPublic(\true);
            $containerBuilder->setAlias(\RectorPrefix20210206\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \RectorPrefix20210206\Symplify\PhpConfigPrinter\Dummy\DummyYamlFileContentProvider::class);
        }
        if (!$containerBuilder->has(\RectorPrefix20210206\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class)) {
            $containerBuilder->autowire(\RectorPrefix20210206\Symplify\PhpConfigPrinter\Dummy\DummySymfonyVersionFeatureGuard::class)->setPublic(\true);
            $containerBuilder->setAlias(\RectorPrefix20210206\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \RectorPrefix20210206\Symplify\PhpConfigPrinter\Dummy\DummySymfonyVersionFeatureGuard::class);
        }
    }
}
