<?php

declare (strict_types=1);
namespace Rector\Utils\ProjectValidator\Command;

use Rector\Core\Application\ActiveRectorsProvider;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Set\RectorSetProvider;
use _PhpScoper006a73f0e455\Symfony\Component\Console\Command\Command;
use _PhpScoper006a73f0e455\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper006a73f0e455\Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper006a73f0e455\Symfony\Component\HttpKernel\KernelInterface;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\SetConfigResolver\ValueObject\Set;
use Throwable;
/**
 * We'll only check one file for now.
 * This makes sure that all sets are "runnable" but keeps the runtime at a managable level
 */
final class ValidateSetsCommand extends \_PhpScoper006a73f0e455\Symfony\Component\Console\Command\Command
{
    /**
     * @var string[]
     */
    private const EXCLUDED_SETS = [
        // required Kernel class to be set in parameters
        'symfony-code-quality',
    ];
    /**
     * @var RectorSetProvider
     */
    private $rectorSetProvider;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct(\Rector\Set\RectorSetProvider $rectorSetProvider, \Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle)
    {
        $this->rectorSetProvider = $rectorSetProvider;
        $this->symfonyStyle = $symfonyStyle;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('[CI] Validate each sets has correct configuration by loading the configs');
    }
    protected function execute(\_PhpScoper006a73f0e455\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper006a73f0e455\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $hasErrors = \false;
        $message = \sprintf('Testing %d sets', \count($this->rectorSetProvider->provide()));
        $this->symfonyStyle->title($message);
        foreach ($this->rectorSetProvider->provide() as $set) {
            if (\in_array($set->getName(), self::EXCLUDED_SETS, \true)) {
                continue;
            }
            $setFileInfo = $set->getSetFileInfo();
            try {
                $rectorKernel = $this->bootRectorKernelWithSet($set);
            } catch (\Throwable $throwable) {
                $message = \sprintf('Failed to load "%s" set from "%s" path', $set->getName(), $setFileInfo->getRelativeFilePathFromCwd());
                $this->symfonyStyle->error($message);
                $this->symfonyStyle->writeln($throwable->getMessage());
                $hasErrors = \true;
                \sleep(3);
                continue;
            }
            $container = $rectorKernel->getContainer();
            $activeRectorsProvider = $container->get(\Rector\Core\Application\ActiveRectorsProvider::class);
            $activeRectors = $activeRectorsProvider->provide();
            $setFileInfo = $set->getSetFileInfo();
            $message = \sprintf('Set "%s" loaded correctly from "%s" path with %d rules', $set->getName(), $setFileInfo->getRelativeFilePathFromCwd(), \count($activeRectors));
            $this->symfonyStyle->success($message);
        }
        return $hasErrors ? \Symplify\PackageBuilder\Console\ShellCode::ERROR : \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
    private function bootRectorKernelWithSet(\Symplify\SetConfigResolver\ValueObject\Set $set) : \_PhpScoper006a73f0e455\Symfony\Component\HttpKernel\KernelInterface
    {
        $rectorKernel = new \Rector\Core\HttpKernel\RectorKernel('prod' . \sha1($set->getName()), \true);
        $rectorKernel->setConfigs([$set->getSetPathname()]);
        $rectorKernel->boot();
        return $rectorKernel;
    }
}
