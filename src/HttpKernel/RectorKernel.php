<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\HttpKernel;

use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use _PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\CompilerPass\MakeRectorsPublicCompilerPass;
use _PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\CompilerPass\MergeImportedRectorConfigureCallValuesCompilerPass;
use _PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\Loader\ConfigurableCallValuesCollectingPhpFileLoader;
use _PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\DelegatingLoader;
use _PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\GlobFileLoader;
use _PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderResolver;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Config\FileLocator;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Kernel;
use _PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use _PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle;
use _PhpScoperb75b35f52b74\Symplify\ConsoleColorDiff\Bundle\ConsoleColorDiffBundle;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\DependencyInjection\CompilerPass\AutowireInterfacesCompilerPass;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\Bundle\SimplePhpDocParserBundle;
use _PhpScoperb75b35f52b74\Symplify\Skipper\Bundle\SkipperBundle;
final class RectorKernel extends \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Kernel implements \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
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
        $this->configureCallValuesCollector = new \_PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector();
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
    public function registerContainerConfiguration(\_PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
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
        return [new \_PhpScoperb75b35f52b74\Symplify\ConsoleColorDiff\Bundle\ConsoleColorDiffBundle(), new \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle(), new \_PhpScoperb75b35f52b74\Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle(), new \_PhpScoperb75b35f52b74\Symplify\Skipper\Bundle\SkipperBundle(), new \_PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\Bundle\SimplePhpDocParserBundle()];
    }
    protected function build(\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \_PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
        // autowire Rectors by default (mainly for 3rd party code)
        $containerBuilder->addCompilerPass(new \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\DependencyInjection\CompilerPass\AutowireInterfacesCompilerPass([\_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface::class]));
        $containerBuilder->addCompilerPass(new \_PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\CompilerPass\MakeRectorsPublicCompilerPass());
        // add all merged arguments of Rector services
        $containerBuilder->addCompilerPass(new \_PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\CompilerPass\MergeImportedRectorConfigureCallValuesCompilerPass($this->configureCallValuesCollector));
    }
    /**
     * This allows to use "%vendor%" variables in imports
     * @param ContainerInterface|ContainerBuilder $container
     */
    protected function getContainerLoader(\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface $container) : \_PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $fileLocator = new \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Config\FileLocator($this);
        $loaderResolver = new \_PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\LoaderResolver([new \_PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\GlobFileLoader($fileLocator), new \_PhpScoperb75b35f52b74\Rector\Core\DependencyInjection\Loader\ConfigurableCallValuesCollectingPhpFileLoader($container, $fileLocator, $this->configureCallValuesCollector)]);
        return new \_PhpScoperb75b35f52b74\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
