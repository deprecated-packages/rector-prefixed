<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Bundle;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScopere8e811afab72\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\DependencyInjection\Extension\PhpConfigPrinterExtension;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Dummy\DummySymfonyVersionFeatureGuard;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Dummy\DummyYamlFileContentProvider;
/**
 * This class is dislocated in non-standard location, so it's not added by symfony/flex
 * to bundles.php and cause app to crash. See https://github.com/symplify/symplify/issues/1952#issuecomment-628765364
 */
final class PhpConfigPrinterBundle extends \_PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $this->registerDefaultImplementations($containerBuilder);
        $containerBuilder->addCompilerPass(new \_PhpScopere8e811afab72\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
    protected function createContainerExtension() : ?\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\DependencyInjection\Extension\PhpConfigPrinterExtension();
    }
    private function registerDefaultImplementations(\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // set default implementations, if none provided - for better developer experience out of the box
        if (!$containerBuilder->has(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class)) {
            $containerBuilder->autowire(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Dummy\DummyYamlFileContentProvider::class)->setPublic(\true);
            $containerBuilder->setAlias(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface::class, \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Dummy\DummyYamlFileContentProvider::class);
        }
        if (!$containerBuilder->has(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class)) {
            $containerBuilder->autowire(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Dummy\DummySymfonyVersionFeatureGuard::class)->setPublic(\true);
            $containerBuilder->setAlias(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface::class, \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Dummy\DummySymfonyVersionFeatureGuard::class);
        }
    }
}
