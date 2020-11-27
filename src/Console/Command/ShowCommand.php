<?php

declare (strict_types=1);
namespace Rector\Core\Console\Command;

use Rector\Core\Application\ActiveRectorsProvider;
use Rector\Core\Configuration\Option;
use Rector\Core\Console\Output\RectorConfigurationFormatter;
use _PhpScopera143bcca66cb\Symfony\Component\Console\Input\InputInterface;
use _PhpScopera143bcca66cb\Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ShowCommand extends \Rector\Core\Console\Command\AbstractCommand
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
    /**
     * @var RectorConfigurationFormatter
     */
    private $rectorConfigurationFormatter;
    public function __construct(\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider, \Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \Rector\Core\Console\Output\RectorConfigurationFormatter $rectorConfigurationFormatter)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->activeRectorsProvider = $activeRectorsProvider;
        $this->parameterProvider = $parameterProvider;
        parent::__construct();
        $this->rectorConfigurationFormatter = $rectorConfigurationFormatter;
    }
    protected function configure() : void
    {
        $this->setDescription('Show loaded Rectors with their configuration');
    }
    protected function execute(\_PhpScopera143bcca66cb\Symfony\Component\Console\Input\InputInterface $input, \_PhpScopera143bcca66cb\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->reportLoadedRectors();
        $this->reportLoadedSets();
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
    private function reportLoadedRectors() : void
    {
        $activeRectors = $this->activeRectorsProvider->provide();
        $rectorCount = \count($activeRectors);
        if ($rectorCount > 0) {
            $this->symfonyStyle->title('Loaded Rector rules');
            foreach ($activeRectors as $rector) {
                $this->symfonyStyle->writeln(' * ' . \get_class($rector));
                $this->rectorConfigurationFormatter->printRectorConfiguration($rector);
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
            $setFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($set);
            $setFilePaths[] = $setFileInfo->getRelativeFilePathFromCwd();
        }
        $this->symfonyStyle->listing($setFilePaths);
        $message = \sprintf('%d loaded sets', \count($sets));
        $this->symfonyStyle->success($message);
    }
}
