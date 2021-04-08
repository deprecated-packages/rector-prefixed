<?php

declare (strict_types=1);
namespace Rector\Core\Console\Command;

use Rector\Core\Application\ActiveRectorsProvider;
use Rector\Core\Configuration\Option;
use RectorPrefix20210408\Symfony\Component\Console\Command\Command;
use RectorPrefix20210408\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210408\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210408\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210408\Symplify\PackageBuilder\Console\ShellCode;
use RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
final class ShowCommand extends \RectorPrefix20210408\Symfony\Component\Console\Command\Command
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
    public function __construct(\RectorPrefix20210408\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider, \RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
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
    protected function execute(\RectorPrefix20210408\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210408\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->reportLoadedRectors();
        $this->reportLoadedSets();
        return \RectorPrefix20210408\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
    private function reportLoadedRectors() : void
    {
        $activeRectors = $this->activeRectorsProvider->provide();
        $rectorCount = \count($activeRectors);
        if ($rectorCount > 0) {
            $this->symfonyStyle->title('Loaded Rector rules');
            foreach ($activeRectors as $activeRector) {
                $this->symfonyStyle->writeln(' * ' . \get_class($activeRector));
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
        $sets = (array) $this->parameterProvider->provideParameter(\Rector\Core\Configuration\Option::SETS);
        if ($sets === []) {
            return;
        }
        $this->symfonyStyle->newLine(2);
        $this->symfonyStyle->title('Loaded Sets');
        \sort($sets);
        $setFilePaths = [];
        foreach ($sets as $set) {
            $setFileInfo = new \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo($set);
            $setFilePaths[] = $setFileInfo->getRelativeFilePathFromCwd();
        }
        $this->symfonyStyle->listing($setFilePaths);
        $message = \sprintf('%d loaded sets', \count($sets));
        $this->symfonyStyle->success($message);
    }
}
