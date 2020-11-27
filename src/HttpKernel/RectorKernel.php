<?php

declare (strict_types=1);
namespace Rector\Core\HttpKernel;

use Rector\Core\Contract\Rector\RectorInterface;
use Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use Rector\Core\DependencyInjection\CompilerPass\MakeRectorsPublicCompilerPass;
use Rector\Core\DependencyInjection\CompilerPass\MergeImportedRectorConfigureCallValuesCompilerPass;
use Rector\Core\DependencyInjection\Loader\ConfigurableCallValuesCollectingPhpFileLoader;
use _PhpScoper006a73f0e455\Symfony\Component\Config\Loader\DelegatingLoader;
use _PhpScoper006a73f0e455\Symfony\Component\Config\Loader\GlobFileLoader;
use _PhpScoper006a73f0e455\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoper006a73f0e455\Symfony\Component\Config\Loader\LoaderResolver;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Config\FileLocator;
use _PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Kernel;
use Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use Symplify\ComposerJsonManipulator\ComposerJsonManipulatorBundle;
use Symplify\ConsoleColorDiff\ConsoleColorDiffBundle;
use Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use Symplify\PackageBuilder\DependencyInjection\CompilerPass\AutowireInterfacesCompilerPass;
use Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use Symplify\Skipper\Bundle\SkipperBundle;
final class RectorKernel extends \_PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Kernel implements \Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
{
    /**
     * @var string[]
     */
    private $configs = [];
    /**
     * @var ConfigureCallValuesCollector
     */
    private $configureCallValuesCollector;
    public function __construct(string $environment, bool $debug)
    {
        $this->configureCallValuesCollector = new \Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector();
        parent::__construct($environment, $debug);
    }
    public function getCacheDir() : string
    {
        // manually configured, so it can be replaced in phar
        return \sys_get_temp_dir() . '/_rector';
    }
    public function getLogDir() : string
    {
        // manually configured, so it can be replaced in phar
        return \sys_get_temp_dir() . '/_rector_log';
    }
    public function registerContainerConfiguration(\_PhpScoper006a73f0e455\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    /**
     * @param string[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        $this->configs = $configs;
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : array
    {
        return [new \Symplify\ConsoleColorDiff\ConsoleColorDiffBundle(), new \Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle(), new \Symplify\ComposerJsonManipulator\ComposerJsonManipulatorBundle(), new \Symplify\Skipper\Bundle\SkipperBundle()];
    }
    protected function build(\_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
        // autowire Rectors by default (mainly for 3rd party code)
        $containerBuilder->addCompilerPass(new \Symplify\PackageBuilder\DependencyInjection\CompilerPass\AutowireInterfacesCompilerPass([\Rector\Core\Contract\Rector\RectorInterface::class]));
        $containerBuilder->addCompilerPass(new \Rector\Core\DependencyInjection\CompilerPass\MakeRectorsPublicCompilerPass());
        // add all merged arguments of Rector services
        $containerBuilder->addCompilerPass(new \Rector\Core\DependencyInjection\CompilerPass\MergeImportedRectorConfigureCallValuesCompilerPass($this->configureCallValuesCollector));
    }
    /**
     * This allows to use "%vendor%" variables in imports
     * @param ContainerInterface|ContainerBuilder $container
     */
    protected function getContainerLoader(\_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerInterface $container) : \_PhpScoper006a73f0e455\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $fileLocator = new \_PhpScoper006a73f0e455\Symfony\Component\HttpKernel\Config\FileLocator($this);
        $loaderResolver = new \_PhpScoper006a73f0e455\Symfony\Component\Config\Loader\LoaderResolver([new \_PhpScoper006a73f0e455\Symfony\Component\Config\Loader\GlobFileLoader($fileLocator), new \Rector\Core\DependencyInjection\Loader\ConfigurableCallValuesCollectingPhpFileLoader($container, $fileLocator, $this->configureCallValuesCollector)]);
        return new \_PhpScoper006a73f0e455\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
