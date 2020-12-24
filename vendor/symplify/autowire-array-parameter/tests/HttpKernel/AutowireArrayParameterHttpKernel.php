<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\Tests\HttpKernel;

use _PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Kernel;
use _PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class AutowireArrayParameterHttpKernel extends \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Kernel
{
    public function registerContainerConfiguration(\_PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
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
    protected function build(\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \_PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
    }
}
