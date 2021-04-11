<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\Output;

use RectorPrefix20210411\Nette\Utils\Strings;
use Rector\ChangesReporting\Annotation\RectorsChangelogResolver;
use Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use Rector\ChangesReporting\Contract\Output\OutputFormatterInterface;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\Application\RectorError;
use Rector\Core\ValueObject\Reporting\FileDiff;
use RectorPrefix20210411\Symfony\Component\Console\Style\SymfonyStyle;
final class ConsoleOutputFormatter implements \Rector\ChangesReporting\Contract\Output\OutputFormatterInterface
{
    /**
     * @var string
     */
    public const NAME = 'console';
    /**
     * @var string
     * @see https://regex101.com/r/q8I66g/1
     */
    private const ON_LINE_REGEX = '# on line #';
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var RectorsChangelogResolver
     */
    private $rectorsChangelogResolver;
    public function __construct(\Rector\Core\Configuration\Configuration $configuration, \RectorPrefix20210411\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Rector\ChangesReporting\Annotation\RectorsChangelogResolver $rectorsChangelogResolver)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->configuration = $configuration;
        $this->rectorsChangelogResolver = $rectorsChangelogResolver;
    }
    public function report(\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : void
    {
        if ($this->configuration->getOutputFile()) {
            $message = \sprintf('Option "--%s" can be used only with "--%s %s"', \Rector\Core\Configuration\Option::OPTION_OUTPUT_FILE, \Rector\Core\Configuration\Option::OPTION_OUTPUT_FORMAT, 'json');
            $this->symfonyStyle->error($message);
        }
        if ($this->configuration->shouldShowDiffs()) {
            $this->reportFileDiffs($errorAndDiffCollector->getFileDiffs());
        }
        $this->reportErrors($errorAndDiffCollector->getErrors());
        $this->reportRemovedFilesAndNodes($errorAndDiffCollector);
        if ($errorAndDiffCollector->getErrors() !== []) {
            return;
        }
        $message = $this->createSuccessMessage($errorAndDiffCollector);
        $this->symfonyStyle->success($message);
    }
    public function getName() : string
    {
        return self::NAME;
    }
    /**
     * @param FileDiff[] $fileDiffs
     */
    private function reportFileDiffs(array $fileDiffs) : void
    {
        if (\count($fileDiffs) <= 0) {
            return;
        }
        // normalize
        \ksort($fileDiffs);
        $message = \sprintf('%d file%s with changes', \count($fileDiffs), \count($fileDiffs) === 1 ? '' : 's');
        $this->symfonyStyle->title($message);
        $i = 0;
        foreach ($fileDiffs as $fileDiff) {
            $relativeFilePath = $fileDiff->getRelativeFilePath();
            $message = \sprintf('<options=bold>%d) %s</>', ++$i, $relativeFilePath);
            $this->symfonyStyle->writeln($message);
            $this->symfonyStyle->newLine();
            $this->symfonyStyle->writeln($fileDiff->getDiffConsoleFormatted());
            $this->symfonyStyle->newLine();
            $rectorsChangelogsLines = $this->createRectorChangelogLines($fileDiff);
            if ($fileDiff->getRectorChanges() !== []) {
                $this->symfonyStyle->writeln('<options=underscore>Applied rules:</>');
                $this->symfonyStyle->newLine();
                $this->symfonyStyle->listing($rectorsChangelogsLines);
                $this->symfonyStyle->newLine();
            }
        }
    }
    /**
     * @param RectorError[] $errors
     */
    private function reportErrors(array $errors) : void
    {
        foreach ($errors as $error) {
            $errorMessage = $error->getMessage();
            $errorMessage = $this->normalizePathsToRelativeWithLine($errorMessage);
            $message = \sprintf('Could not process "%s" file%s, due to: %s"%s".', $error->getRelativeFilePath(), $error->getRectorClass() ? ' by "' . $error->getRectorClass() . '"' : '', \PHP_EOL, $errorMessage);
            if ($error->getLine()) {
                $message .= ' On line: ' . $error->getLine();
            }
            $this->symfonyStyle->error($message);
        }
    }
    private function reportRemovedFilesAndNodes(\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : void
    {
        if ($errorAndDiffCollector->getAddFilesCount() !== 0) {
            $message = \sprintf('%d files were added', $errorAndDiffCollector->getAddFilesCount());
            $this->symfonyStyle->note($message);
        }
        if ($errorAndDiffCollector->getRemovedFilesCount() !== 0) {
            $message = \sprintf('%d files were removed', $errorAndDiffCollector->getRemovedFilesCount());
            $this->symfonyStyle->note($message);
        }
        $this->reportRemovedNodes($errorAndDiffCollector);
    }
    private function normalizePathsToRelativeWithLine(string $errorMessage) : string
    {
        $regex = '#' . \preg_quote(\getcwd(), '#') . '/#';
        $errorMessage = \RectorPrefix20210411\Nette\Utils\Strings::replace($errorMessage, $regex, '');
        return \RectorPrefix20210411\Nette\Utils\Strings::replace($errorMessage, self::ON_LINE_REGEX, ':');
    }
    private function reportRemovedNodes(\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : void
    {
        if ($errorAndDiffCollector->getRemovedNodeCount() === 0) {
            return;
        }
        $message = \sprintf('%d nodes were removed', $errorAndDiffCollector->getRemovedNodeCount());
        $this->symfonyStyle->warning($message);
    }
    private function createSuccessMessage(\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : string
    {
        $changeCount = $errorAndDiffCollector->getFileDiffsCount() + $errorAndDiffCollector->getRemovedAndAddedFilesCount();
        if ($changeCount === 0) {
            return 'Rector is done!';
        }
        return \sprintf('%d file%s %s by Rector', $changeCount, $changeCount > 1 ? 's' : '', $this->configuration->isDryRun() ? 'would have changed (dry-run)' : ($changeCount === 1 ? 'has' : 'have') . ' been changed');
    }
    /**
     * @return string[]
     */
    private function createRectorChangelogLines(\Rector\Core\ValueObject\Reporting\FileDiff $fileDiff) : array
    {
        $rectorsChangelogs = $this->rectorsChangelogResolver->resolveIncludingMissing($fileDiff->getRectorClasses());
        $rectorsChangelogsLines = [];
        foreach ($rectorsChangelogs as $rectorClass => $changelog) {
            $rectorsChangelogsLines[] = $changelog === null ? $rectorClass : $rectorClass . ' ' . $changelog;
        }
        return $rectorsChangelogsLines;
    }
}
