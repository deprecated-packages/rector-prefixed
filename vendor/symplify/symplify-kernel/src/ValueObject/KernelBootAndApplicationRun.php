<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\ValueObject;

use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Application;
use _PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\KernelInterface;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Input\StaticInputDetector;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\ShellCode;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\BootException;
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
    public function run() : void
    {
        try {
            $this->booKernelAndRunApplication();
        } catch (\Throwable $throwable) {
            $symfonyStyleFactory = new \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory();
            $symfonyStyle = $symfonyStyleFactory->create();
            $symfonyStyle->error($throwable->getMessage());
            exit(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\ShellCode::ERROR);
        }
    }
    private function createKernel() : \_PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\KernelInterface
    {
        // random has is needed, so cache is invalidated and changes from config are loaded
        $environment = 'prod' . \random_int(1, 100000);
        $kernelClass = $this->kernelClass;
        $kernel = new $kernelClass($environment, \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Console\Input\StaticInputDetector::isDebug());
        $this->setExtraConfigs($kernel, $kernelClass);
        return $kernel;
    }
    private function booKernelAndRunApplication() : void
    {
        $kernel = $this->createKernel();
        if ($kernel instanceof \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface && $this->extraConfigs !== []) {
            $kernel->setConfigs($this->extraConfigs);
        }
        $kernel->boot();
        $container = $kernel->getContainer();
        /** @var Application $application */
        $application = $container->get(\_PhpScoper0a2ac50786fa\Symfony\Component\Console\Application::class);
        exit($application->run());
    }
    private function setExtraConfigs(\_PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\KernelInterface $kernel, string $kernelClass) : void
    {
        if ($this->extraConfigs === []) {
            return;
        }
        if (\is_a($kernel, \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface::class, \true)) {
            /** @var ExtraConfigAwareKernelInterface $kernel */
            $kernel->setConfigs($this->extraConfigs);
        } else {
            $message = \sprintf('Extra configs are set, but the "%s" kernel class is missing "%s" interface', $kernelClass, \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface::class);
            throw new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\BootException($message);
        }
    }
    /**
     * @param class-string $kernelClass
     */
    private function setKernelClass(string $kernelClass) : void
    {
        if (!\is_a($kernelClass, \_PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\KernelInterface::class, \true)) {
            $message = \sprintf('Class "%s" must by type of "%s"', $kernelClass, \_PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\KernelInterface::class);
            throw new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\BootException($message);
        }
        $this->kernelClass = $kernelClass;
    }
}
