<?php

declare (strict_types=1);
namespace Rector\ChangesReporting\Output;

use RectorPrefix20210417\Nette\Utils\Strings;
use Rector\ChangesReporting\Annotation\RectorsChangelogResolver;
use Rector\ChangesReporting\Contract\Output\OutputFormatterInterface;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\Application\RectorError;
use Rector\Core\ValueObject\ProcessResult;
use Rector\Core\ValueObject\Reporting\FileDiff;
use RectorPrefix20210417\Symfony\Component\Console\Style\SymfonyStyle;
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
    public function __construct(\Rector\Core\Configuration\Configuration $configuration, \RectorPrefix20210417\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Rector\ChangesReporting\Annotation\RectorsChangelogResolver $rectorsChangelogResolver)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->configuration = $configuration;
        $this->rectorsChangelogResolver = $rectorsChangelogResolver;
    }
    public function report(\Rector\Core\ValueObject\ProcessResult $processResult) : void
    {
        if ($this->configuration->getOutputFile()) {
            $message = \sprintf('Option "--%s" can be used only with "--%s %s"', \Rector\Core\Configuration\Option::OPTION_OUTPUT_FILE, \Rector\Core\Configuration\Option::OPTION_OUTPUT_FORMAT, 'json');
            $this->symfonyStyle->error($message);
        }
        if ($this->configuration->shouldShowDiffs()) {
            $this->reportFileDiffs($processResult->getFileDiffs());
        }
        $this->reportErrors($processResult->getErrors());
        $this->reportRemovedFilesAndNodes($processResult);
        if ($processResult->getErrors() !== []) {
            return;
        }
        $message = $this->createSuccessMessage($processResult);
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
    private function reportRemovedFilesAndNodes(\Rector\Core\ValueObject\ProcessResult $processResult) : void
    {
        if ($processResult->getAddedFilesCount() !== 0) {
            $message = \sprintf('%d files were added', $processResult->getAddedFilesCount());
            $this->symfonyStyle->note($message);
        }
        if ($processResult->getRemovedFilesCount() !== 0) {
            $message = \sprintf('%d files were removed', $processResult->getRemovedFilesCount());
            $this->symfonyStyle->note($message);
        }
        $this->reportRemovedNodes($processResult);
    }
    private function normalizePathsToRelativeWithLine(string $errorMessage) : string
    {
        $regex = '#' . \preg_quote(\getcwd(), '#') . '/#';
        $errorMessage = \RectorPrefix20210417\Nette\Utils\Strings::replace($errorMessage, $regex, '');
        return \RectorPrefix20210417\Nette\Utils\Strings::replace($errorMessage, self::ON_LINE_REGEX, ':');
    }
    private function reportRemovedNodes(\Rector\Core\ValueObject\ProcessResult $processResult) : void
    {
        if ($processResult->getRemovedNodeCount() === 0) {
            return;
        }
        $message = \sprintf('%d nodes were removed', $processResult->getRemovedNodeCount());
        $this->symfonyStyle->warning($message);
    }
    private function createSuccessMessage(\Rector\Core\ValueObject\ProcessResult $processResult) : string
    {
        $changeCount = \count($processResult->getFileDiffs()) + $processResult->getRemovedAndAddedFilesCount();
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
            $rectorShortClass = (string) \RectorPrefix20210417\Nette\Utils\Strings::after($rectorClass, '\\', -1);
            $rectorsChangelogsLines[] = $changelog === null ? $rectorShortClass : $rectorShortClass . ' (' . $changelog . ')';
        }
        return $rectorsChangelogsLines;
    }
}
