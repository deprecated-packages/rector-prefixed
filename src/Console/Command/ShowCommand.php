<?php

declare (strict_types=1);
namespace Rector\Core\Console\Command;

use Rector\Core\Configuration\Option;
use Rector\Core\Contract\Rector\RectorInterface;
use Rector\PostRector\Application\PostFileProcessor;
use Rector\PostRector\Contract\Rector\PostRectorInterface;
use RectorPrefix20210506\Symfony\Component\Console\Command\Command;
use RectorPrefix20210506\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210506\Symfony\Component\Console\Output\OutputInterface;
use RectorPrefix20210506\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210506\Symplify\PackageBuilder\Console\ShellCode;
use RectorPrefix20210506\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ShowCommand extends \RectorPrefix20210506\Symfony\Component\Console\Command\Command
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var RectorInterface[]
     */
    private $rectors = [];
    /**
     * @param RectorInterface[] $rectors
     */
    public function __construct(\RectorPrefix20210506\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \RectorPrefix20210506\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, array $rectors)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->parameterProvider = $parameterProvider;
        $this->rectors = $rectors;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('Show loaded Rectors with their configuration');
    }
    protected function execute(\RectorPrefix20210506\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20210506\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $this->reportLoadedRectors();
        $this->reportLoadedSets();
        return \RectorPrefix20210506\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
    private function reportLoadedRectors() : void
    {
        $rectors = \array_filter($this->rectors, function (\Rector\Core\Contract\Rector\RectorInterface $rector) {
            return !$rector instanceof \Rector\PostRector\Contract\Rector\PostRectorInterface;
        });
        $rectorCount = \count($rectors);
        if ($rectorCount > 0) {
            $this->symfonyStyle->title('Loaded Rector rules');
            foreach ($rectors as $rector) {
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
