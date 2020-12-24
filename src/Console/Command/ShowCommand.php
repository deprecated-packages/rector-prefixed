<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Console\Command;

use _PhpScoper0a6b37af0871\Rector\Core\Application\ActiveRectorsProvider;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\Option;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\ShellCode;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ShowCommand extends \_PhpScoper0a6b37af0871\Rector\Core\Console\Command\AbstractCommand
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var ActiveRectorsProvider
     */
    private $activeRectorsProvider;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoper0a6b37af0871\Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider, \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->activeRectorsProvider = $activeRectorsProvider;
        $this->parameterProvider = $parameterProvider;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('Show loaded Rectors with their configuration');
    }
    protected function execute(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->reportLoadedRectors();
        $this->reportLoadedSets();
        return \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
    private function reportLoadedRectors() : void
    {
        $activeRectors = $this->activeRectorsProvider->provide();
        $rectorCount = \count($activeRectors);
        if ($rectorCount > 0) {
            $this->symfonyStyle->title('Loaded Rector rules');
            foreach ($activeRectors as $rector) {
                $this->symfonyStyle->writeln(' * ' . \get_class($rector));
            }
            $message = \sprintf('%d loaded Rectors', $rectorCount);
            $this->symfonyStyle->success($message);
        } else {
            $warningMessage = \sprintf('No Rectors were loaded.%sAre sure your "rector.php" config is in the root?%sTry "--config <path>" option to include it.', \PHP_EOL . \PHP_EOL, \PHP_EOL);
            $this->symfonyStyle->warning($warningMessage);
        }
    }
    private function reportLoadedSets() : void
    {
        $sets = (array) $this->parameterProvider->provideParameter(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\Option::SETS);
        if ($sets === []) {
            return;
        }
        $this->symfonyStyle->newLine(2);
        $this->symfonyStyle->title('Loaded Sets');
        \sort($sets);
        $setFilePaths = [];
        foreach ($sets as $set) {
            $setFileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($set);
            $setFilePaths[] = $setFileInfo->getRelativeFilePathFromCwd();
        }
        $this->symfonyStyle->listing($setFilePaths);
        $message = \sprintf('%d loaded sets', \count($sets));
        $this->symfonyStyle->success($message);
    }
}
