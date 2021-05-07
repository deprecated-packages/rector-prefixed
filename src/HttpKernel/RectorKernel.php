<?php

declare (strict_types=1);
namespace Rector\Core\HttpKernel;

use Rector\Core\Contract\Rector\RectorInterface;
use Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector;
use Rector\Core\DependencyInjection\CompilerPass\DeprecationWarningCompilerPass;
use Rector\Core\DependencyInjection\CompilerPass\MakeRectorsPublicCompilerPass;
use Rector\Core\DependencyInjection\CompilerPass\MergeImportedRectorConfigureCallValuesCompilerPass;
use Rector\Core\DependencyInjection\CompilerPass\RemoveSkippedRectorsCompilerPass;
use Rector\Core\DependencyInjection\CompilerPass\VerifyRectorServiceExistsCompilerPass;
use Rector\Core\DependencyInjection\Loader\ConfigurableCallValuesCollectingPhpFileLoader;
use RectorPrefix20210507\Symfony\Component\Config\Loader\DelegatingLoader;
use RectorPrefix20210507\Symfony\Component\Config\Loader\GlobFileLoader;
use RectorPrefix20210507\Symfony\Component\Config\Loader\LoaderInterface;
use RectorPrefix20210507\Symfony\Component\Config\Loader\LoaderResolver;
use RectorPrefix20210507\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210507\Symfony\Component\DependencyInjection\ContainerInterface;
use RectorPrefix20210507\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use RectorPrefix20210507\Symfony\Component\HttpKernel\Config\FileLocator;
use RectorPrefix20210507\Symfony\Component\HttpKernel\Kernel;
use RectorPrefix20210507\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use RectorPrefix20210507\Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle;
use RectorPrefix20210507\Symplify\ConsoleColorDiff\Bundle\ConsoleColorDiffBundle;
use RectorPrefix20210507\Symplify\PackageBuilder\DependencyInjection\CompilerPass\AutowireInterfacesCompilerPass;
use RectorPrefix20210507\Symplify\SimplePhpDocParser\Bundle\SimplePhpDocParserBundle;
use RectorPrefix20210507\Symplify\Skipper\Bundle\SkipperBundle;
use Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @todo possibly remove symfony/http-kernel and use the container build only
 */
final class RectorKernel extends \RectorPrefix20210507\Symfony\Component\HttpKernel\Kernel
{
    /**
     * @var SmartFileInfo[]
     */
    private $configFileInfos = [];
    /**
     * @var ConfigureCallValuesCollector
     */
    private $configureCallValuesCollector;
    /**
     * @param SmartFileInfo[] $configFileInfos
     */
    public function __construct(string $environment, bool $debug, array $configFileInfos)
    {
        $this->configureCallValuesCollector = new \Rector\Core\DependencyInjection\Collector\ConfigureCallValuesCollector();
        $this->configFileInfos = $configFileInfos;
        parent::__construct($environment, $debug);
    }
    public function getCacheDir() : string
    {
        $cacheDirectory = $_ENV['KERNEL_CACHE_DIRECTORY'] ?? null;
        if ($cacheDirectory !== null) {
            return $cacheDirectory . '/' . $this->environment;
        }
        // manually configured, so it can be replaced in phar
        return \sys_get_temp_dir() . '/rector/cache';
    }
    public function getLogDir() : string
    {
        // manually configured, so it can be replaced in phar
        return \sys_get_temp_dir() . '/rector/log';
    }
    public function registerContainerConfiguration(\RectorPrefix20210507\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        foreach ($this->configFileInfos as $configFileInfo) {
            $loader->load($configFileInfo->getRealPath());
        }
    }
    /**
     * @return iterable<BundleInterface>
     */
    public function registerBundles() : iterable
    {
        return [new \RectorPrefix20210507\Symplify\ConsoleColorDiff\Bundle\ConsoleColorDiffBundle(), new \RectorPrefix20210507\Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle(), new \RectorPrefix20210507\Symplify\Skipper\Bundle\SkipperBundle(), new \RectorPrefix20210507\Symplify\SimplePhpDocParser\Bundle\SimplePhpDocParserBundle()];
    }
    protected function build(\RectorPrefix20210507\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // @see https://symfony.com/blog/new-in-symfony-4-4-dependency-injection-improvements-part-1
        $containerBuilder->setParameter('container.dumper.inline_factories', \true);
        // to fix reincluding files again
        $containerBuilder->setParameter('container.dumper.inline_class_loader', \false);
        // must run before AutowireArrayParameterCompilerPass, as the autowired array cannot contain removed services
        $containerBuilder->addCompilerPass(new \Rector\Core\DependencyInjection\CompilerPass\RemoveSkippedRectorsCompilerPass());
        $containerBuilder->addCompilerPass(new \RectorPrefix20210507\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
        // autowire Rectors by default (mainly for tests)
        $containerBuilder->addCompilerPass(new \RectorPrefix20210507\Symplify\PackageBuilder\DependencyInjection\CompilerPass\AutowireInterfacesCompilerPass([\Rector\Core\Contract\Rector\RectorInterface::class]));
        $containerBuilder->addCompilerPass(new \Rector\Core\DependencyInjection\CompilerPass\MakeRectorsPublicCompilerPass());
        $containerBuilder->addCompilerPass(new \Rector\Core\DependencyInjection\CompilerPass\DeprecationWarningCompilerPass());
        // add all merged arguments of Rector services
        $containerBuilder->addCompilerPass(new \Rector\Core\DependencyInjection\CompilerPass\MergeImportedRectorConfigureCallValuesCompilerPass($this->configureCallValuesCollector));
        $containerBuilder->addCompilerPass(new \Rector\Core\DependencyInjection\CompilerPass\VerifyRectorServiceExistsCompilerPass());
    }
    /**
     * This allows to use "%vendor%" variables in imports
     * @param ContainerInterface|ContainerBuilder $container
     */
    protected function getContainerLoader(\RectorPrefix20210507\Symfony\Component\DependencyInjection\ContainerInterface $container) : \RectorPrefix20210507\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $fileLocator = new \RectorPrefix20210507\Symfony\Component\HttpKernel\Config\FileLocator($this);
        $loaderResolver = new \RectorPrefix20210507\Symfony\Component\Config\Loader\LoaderResolver([new \RectorPrefix20210507\Symfony\Component\Config\Loader\GlobFileLoader($fileLocator), new \Rector\Core\DependencyInjection\Loader\ConfigurableCallValuesCollectingPhpFileLoader($container, $fileLocator, $this->configureCallValuesCollector)]);
        return new \RectorPrefix20210507\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
