<?php

declare (strict_types=1);
namespace Rector\Utils\DoctrineAnnotationParserSyncer\Command;

use Rector\Core\Configuration\Option;
use Rector\Utils\DoctrineAnnotationParserSyncer\Contract\ClassSyncerInterface;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\Command\Command;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\Input\InputOption;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileInfo;
final class SyncAnnotationParserCommand extends \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Command\Command
{
    /**
     * @var ClassSyncerInterface[]
     */
    private $classSyncers = [];
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @param ClassSyncerInterface[] $classSyncers
     */
    public function __construct(array $classSyncers, \Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->classSyncers = $classSyncers;
        $this->parameterProvider = $parameterProvider;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('[DEV] Generate value-preserving DocParser from doctrine/annotation');
        $this->addOption(\Rector\Core\Configuration\Option::OPTION_DRY_RUN, 'n', \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'See diff of changes, do not save them to files.');
    }
    protected function execute(\_PhpScoper88fe6e0ad041\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        // disable imports
        $this->parameterProvider->changeParameter(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \false);
        $dryRun = (bool) $input->getOption(\Rector\Core\Configuration\Option::OPTION_DRY_RUN);
        foreach ($this->classSyncers as $classSyncer) {
            $isSuccess = $classSyncer->sync($dryRun);
            if (!$isSuccess) {
                $sourceFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($classSyncer->getSourceFilePath());
                $message = \sprintf('File "%s" has changed,%sregenerate it: %s', $sourceFileInfo->getRelativeFilePathFromCwd(), \PHP_EOL, 'bin/rector sync-annotation-parser');
                $this->symfonyStyle->error($message);
                return \Symplify\PackageBuilder\Console\ShellCode::ERROR;
            }
            $message = $this->createMessageAboutFileChanges($classSyncer, $dryRun);
            $this->symfonyStyle->note($message);
        }
        $this->symfonyStyle->success('Done');
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
    private function createMessageAboutFileChanges(\Rector\Utils\DoctrineAnnotationParserSyncer\Contract\ClassSyncerInterface $classSyncer, bool $dryRun) : string
    {
        $sourceFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($classSyncer->getSourceFilePath());
        $targetFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($classSyncer->getTargetFilePath());
        $messageFormat = $dryRun ? 'Original "%s" is in sync with "%s"' : 'Original "%s" was changed and refactored to "%s"';
        return \sprintf($messageFormat, $sourceFileInfo->getRelativeFilePathFromCwd(), $targetFileInfo->getRelativeFilePathFromCwd());
    }
}
