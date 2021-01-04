<?php

declare (strict_types=1);
namespace RectorPrefix20210104\Symplify\AutowireArrayParameter\Tests\HttpKernel;

use RectorPrefix20210104\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210104\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210104\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20210104\Symfony\Component\HttpKernel\Kernel;
use RectorPrefix20210104\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AutowireArrayParameterHttpKernel extends \RectorPrefix20210104\Symfony\Component\HttpKernel\Kernel
{
    public function registerContainerConfiguration(\RectorPrefix20210104\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
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
    protected function build(\RectorPrefix20210104\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210104\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
}
