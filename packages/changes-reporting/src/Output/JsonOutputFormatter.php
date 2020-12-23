<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\ChangesReporting\Output;

use _PhpScoper0a2ac50786fa\Nette\Utils\Json;
use _PhpScoper0a2ac50786fa\Rector\ChangesReporting\Application\ErrorAndDiffCollector;
use _PhpScoper0a2ac50786fa\Rector\ChangesReporting\Contract\Output\OutputFormatterInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Configuration;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
final class JsonOutputFormatter implements \_PhpScoper0a2ac50786fa\Rector\ChangesReporting\Contract\Output\OutputFormatterInterface
{
    /**
     * @var string
     */
    public const NAME = 'json';
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Configuration $configuration, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->configuration = $configuration;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function getName() : string
    {
        return self::NAME;
    }
    public function report(\_PhpScoper0a2ac50786fa\Rector\ChangesReporting\Application\ErrorAndDiffCollector $errorAndDiffCollector) : void
    {
        $errorsArray = ['meta' => ['version' => $this->configuration->getPrettyVersion(), 'config' => $this->configuration->getConfigFilePath()], 'totals' => ['changed_files' => $errorAndDiffCollector->getFileDiffsCount(), 'removed_and_added_files_count' => $errorAndDiffCollector->getRemovedAndAddedFilesCount(), 'removed_node_count' => $errorAndDiffCollector->getRemovedNodeCount()]];
        $fileDiffs = $errorAndDiffCollector->getFileDiffs();
        \ksort($fileDiffs);
        foreach ($fileDiffs as $fileDiff) {
            $relativeFilePath = $fileDiff->getRelativeFilePath();
            $errorsArray['file_diffs'][] = ['file' => $relativeFilePath, 'diff' => $fileDiff->getDiff(), 'applied_rectors' => $fileDiff->getRectorClasses()];
            // for Rector CI
            $errorsArray['changed_files'][] = $relativeFilePath;
        }
        $errors = $errorAndDiffCollector->getErrors();
        $errorsArray['totals']['errors'] = \count($errors);
        $errorsData = $this->createErrorsData($errors);
        if ($errorsData !== []) {
            $errorsArray['errors'] = $errorsData;
        }
        $json = \_PhpScoper0a2ac50786fa\Nette\Utils\Json::encode($errorsArray, \_PhpScoper0a2ac50786fa\Nette\Utils\Json::PRETTY);
        $outputFile = $this->configuration->getOutputFile();
        if ($outputFile !== null) {
            $this->smartFileSystem->dumpFile($outputFile, $json . \PHP_EOL);
        } else {
            echo $json . \PHP_EOL;
        }
    }
    /**
     * @param mixed[] $errors
     * @return mixed[]
     */
    private function createErrorsData(array $errors) : array
    {
        $errorsData = [];
        foreach ($errors as $error) {
            $errorData = ['message' => $error->getMessage(), 'file' => $error->getRelativeFilePath()];
            if ($error->getRectorClass()) {
                $errorData['caused_by'] = $error->getRectorClass();
            }
            if ($error->getLine() !== null) {
                $errorData['line'] = $error->getLine();
            }
            $errorsData[] = $errorData;
        }
        return $errorsData;
    }
}
