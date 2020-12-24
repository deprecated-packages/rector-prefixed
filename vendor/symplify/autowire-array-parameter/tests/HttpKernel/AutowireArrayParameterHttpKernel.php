<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\AutowireArrayParameter\Tests\HttpKernel;

use _PhpScopere8e811afab72\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Kernel;
use _PhpScopere8e811afab72\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AutowireArrayParameterHttpKernel extends \_PhpScopere8e811afab72\Symfony\Component\HttpKernel\Kernel
{
    public function registerContainerConfiguration(\_PhpScopere8e811afab72\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../config/autowire_array_parameter.php');
    }
    public function getCacheDir() : string
    {
        return \sys_get_temp_dir() . '/autowire_array_parameter_test';
    }
    public function getLogDir() : string
    {
        return \sys_get_temp_dir() . '/autowire_array_parameter_test_log';
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [];
    }
    protected function build(\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \_PhpScopere8e811afab72\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
}
