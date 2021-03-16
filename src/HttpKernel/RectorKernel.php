<?php

declare (strict_types=1);
namespace Rector\Core\HttpKernel;

use Rector\Core\Contract\Rector\RectorInterface;
use Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use Rector\Core\DependencyInjection\CompilerPass\MakeRectorsPublicCompilerPass;
use Rector\Core\DependencyInjection\CompilerPass\MergeImportedRectorConfigureCallValuesCompilerPass;
use Rector\Core\DependencyInjection\Loader\ConfigurableCallValuesCollectingPhpFileLoader;
use Rector\RectorGenerator\Bundle\RectorGeneratorBundle;
use RectorPrefix20210316\Symfony\Component\Config\Loader\DelegatingLoader;
use RectorPrefix20210316\Symfony\Component\Config\Loader\GlobFileLoader;
use RectorPrefix20210316\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210316\Symfony\Component\Config\Loader\LoaderResolver;
use RectorPrefix20210316\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210316\Symfony\Component\DependencyInjection\ContainerInterface;
use RectorPrefix20210316\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20210316\Symfony\Component\HttpKernel\Config\FileLocator;
use RectorPrefix20210316\Symfony\Component\HttpKernel\Kernel;
use RectorPrefix20210316\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use RectorPrefix20210316\Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle;
use RectorPrefix20210316\Symplify\ConsoleColorDiff\Bundle\ConsoleColorDiffBundle;
use RectorPrefix20210316\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use RectorPrefix20210316\Symplify\PackageBuilder\DependencyInjection\CompilerPass\AutowireInterfacesCompilerPass;
use RectorPrefix20210316\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use RectorPrefix20210316\Symplify\SimplePhpDocParser\Bundle\SimplePhpDocParserBundle;
use RectorPrefix20210316\Symplify\Skipper\Bundle\SkipperBundle;
/**
 * @todo possibly remove symfony/http-kernel and use the container build only
 */
final class RectorKernel extends \RectorPrefix20210316\Symfony\Component\HttpKernel\Kernel implements \RectorPrefix20210316\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
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
        return \sys_get_temp_dir() . '/rector/cache';
    }
    public function getLogDir() : string
    {
        // manually configured, so it can be replaced in phar
        return \sys_get_temp_dir() . '/rector/log';
    }
    public function registerContainerConfiguration(\RectorPrefix20210316\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
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
     * @return iterable<BundleInterface>
     */
    public function registerBundles() : iterable
    {
        $bundles = [new \RectorPrefix20210316\Symplify\ConsoleColorDiff\Bundle\ConsoleColorDiffBundle(), new \RectorPrefix20210316\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle(), new \RectorPrefix20210316\Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle(), new \RectorPrefix20210316\Symplify\Skipper\Bundle\SkipperBundle(), new \RectorPrefix20210316\Symplify\SimplePhpDocParser\Bundle\SimplePhpDocParserBundle()];
        // only for dev
        if (\class_exists(\Rector\RectorGenerator\Bundle\RectorGeneratorBundle::class)) {
            $bundles[] = new \Rector\RectorGenerator\Bundle\RectorGeneratorBundle();
        }
        return $bundles;
    }
    protected function build(\RectorPrefix20210316\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \RectorPrefix20210316\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
        // autowire Rectors by default (mainly for 3rd party code)
        $containerBuilder->addCompilerPass(new \RectorPrefix20210316\Symplify\PackageBuilder\DependencyInjection\CompilerPass\AutowireInterfacesCompilerPass([\Rector\Core\Contract\Rector\RectorInterface::class]));
        $containerBuilder->addCompilerPass(new \Rector\Core\DependencyInjection\CompilerPass\MakeRectorsPublicCompilerPass());
        // add all merged arguments of Rector services
        $containerBuilder->addCompilerPass(new \Rector\Core\DependencyInjection\CompilerPass\MergeImportedRectorConfigureCallValuesCompilerPass($this->configureCallValuesCollector));
    }
    /**
     * This allows to use "%vendor%" variables in imports
     * @param ContainerInterface|ContainerBuilder $container
     */
    protected function getContainerLoader(\RectorPrefix20210316\Symfony\Component\DependencyInjection\ContainerInterface $container) : \RectorPrefix20210316\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $fileLocator = new \RectorPrefix20210316\Symfony\Component\HttpKernel\Config\FileLocator($this);
        $loaderResolver = new \RectorPrefix20210316\Symfony\Component\Config\Loader\LoaderResolver([new \RectorPrefix20210316\Symfony\Component\Config\Loader\GlobFileLoader($fileLocator), new \Rector\Core\DependencyInjection\Loader\ConfigurableCallValuesCollectingPhpFileLoader($container, $fileLocator, $this->configureCallValuesCollector)]);
        return new \RectorPrefix20210316\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
