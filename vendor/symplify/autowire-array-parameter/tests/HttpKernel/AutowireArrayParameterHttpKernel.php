<?php

declare (strict_types=1);
namespace RectorPrefix20201229\Symplify\AutowireArrayParameter\Tests\HttpKernel;

use RectorPrefix20201229\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20201229\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20201229\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20201229\Symfony\Component\HttpKernel\Kernel;
use RectorPrefix20201229\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AutowireArrayParameterHttpKernel extends \RectorPrefix20201229\Symfony\Component\HttpKernel\Kernel
{
    public function registerContainerConfiguration(\RectorPrefix20201229\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
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
    protected function build(\RectorPrefix20201229\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20201229\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
}
