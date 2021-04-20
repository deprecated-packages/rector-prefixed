<?php

declare (strict_types=1);
namespace RectorPrefix20210420\Symplify\SymplifyKernel\ValueObject;

use RectorPrefix20210420\Symfony\Component\Console\Application;
use RectorPrefix20210420\Symfony\Component\HttpKernel\KernelInterface;
use RectorPrefix20210420\Symplify\PackageBuilder\Console\Input\StaticInputDetector;
use RectorPrefix20210420\Symplify\PackageBuilder\Console\ShellCode;
use RectorPrefix20210420\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use RectorPrefix20210420\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use RectorPrefix20210420\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210420\Symplify\SymplifyKernel\Exception\BootException;
use Throwable;
final class KernelBootAndApplicationRun
{
    /**
     * @var class-string
     */
    private $kernelClass;
    /**
     * @var string[]|SmartFileInfo[]
     */
    private $extraConfigs = [];
    /**
     * @param class-string $kernelClass
     * @param string[]|SmartFileInfo[] $extraConfigs
     */
    public function __construct(string $kernelClass, array $extraConfigs = [])
    {
        $this->setKernelClass($kernelClass);
        $this->extraConfigs = $extraConfigs;
    }
    /**
     * @return void
     */
    public function run()
    {
        try {
            $this->booKernelAndRunApplication();
        } catch (\Throwable $throwable) {
            $symfonyStyleFactory = new \RectorPrefix20210420\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory();
            $symfonyStyle = $symfonyStyleFactory->create();
            $symfonyStyle->error($throwable->getMessage());
            exit(\RectorPrefix20210420\Symplify\PackageBuilder\Console\ShellCode::ERROR);
        }
    }
    private function createKernel() : \RectorPrefix20210420\Symfony\Component\HttpKernel\KernelInterface
    {
        // random has is needed, so cache is invalidated and changes from config are loaded
        $environment = 'prod' . \random_int(1, 100000);
        $kernelClass = $this->kernelClass;
        $kernel = new $kernelClass($environment, \RectorPrefix20210420\Symplify\PackageBuilder\Console\Input\StaticInputDetector::isDebug());
        $this->setExtraConfigs($kernel, $kernelClass);
        return $kernel;
    }
    /**
     * @return void
     */
    private function booKernelAndRunApplication()
    {
        $kernel = $this->createKernel();
        if ($kernel instanceof \RectorPrefix20210420\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface && $this->extraConfigs !== []) {
            $kernel->setConfigs($this->extraConfigs);
        }
        $kernel->boot();
        $container = $kernel->getContainer();
        /** @var Application $application */
        $application = $container->get(\RectorPrefix20210420\Symfony\Component\Console\Application::class);
        exit($application->run());
    }
    /**
     * @return void
     */
    private function setExtraConfigs(\RectorPrefix20210420\Symfony\Component\HttpKernel\KernelInterface $kernel, string $kernelClass)
    {
        if ($this->extraConfigs === []) {
            return;
        }
        if (\is_a($kernel, \RectorPrefix20210420\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface::class, \true)) {
            /** @var ExtraConfigAwareKernelInterface $kernel */
            $kernel->setConfigs($this->extraConfigs);
        } else {
            $message = \sprintf('Extra configs are set, but the "%s" kernel class is missing "%s" interface', $kernelClass, \RectorPrefix20210420\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface::class);
            throw new \RectorPrefix20210420\Symplify\SymplifyKernel\Exception\BootException($message);
        }
    }
    /**
     * @param class-string $kernelClass
     * @return void
     */
    private function setKernelClass(string $kernelClass)
    {
        if (!\is_a($kernelClass, \RectorPrefix20210420\Symfony\Component\HttpKernel\KernelInterface::class, \true)) {
            $message = \sprintf('Class "%s" must by type of "%s"', $kernelClass, \RectorPrefix20210420\Symfony\Component\HttpKernel\KernelInterface::class);
            throw new \RectorPrefix20210420\Symplify\SymplifyKernel\Exception\BootException($message);
        }
        $this->kernelClass = $kernelClass;
    }
}
