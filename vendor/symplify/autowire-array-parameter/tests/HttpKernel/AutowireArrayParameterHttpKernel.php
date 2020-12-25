<?php

declare (strict_types=1);
namespace Symplify\AutowireArrayParameter\Tests\HttpKernel;

use _PhpScoper17db12703726\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper17db12703726\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper17db12703726\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoper17db12703726\Symfony\Component\HttpKernel\Kernel;
use Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AutowireArrayParameterHttpKernel extends \_PhpScoper17db12703726\Symfony\Component\HttpKernel\Kernel
{
    public function registerContainerConfiguration(\_PhpScoper17db12703726\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
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
    protected function build(\_PhpScoper17db12703726\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
}
