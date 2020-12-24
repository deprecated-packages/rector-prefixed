<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\PostRunner;

use _PhpScopere8e811afab72\Nette\Utils\Json;
use _PhpScopere8e811afab72\Rector\Core\Contract\PostRunnerInterface;
use _PhpScopere8e811afab72\Rector\Doctrine\Collector\UuidMigrationDataCollector;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @deprecated Replace with interface. Remove whole event system to keep 1 less pattern for same thing
 */
final class ReportEntitiesWithAddedPropertiesPostRunner implements \_PhpScopere8e811afab72\Rector\Core\Contract\PostRunnerInterface
{
    /**
     * @var UuidMigrationDataCollector
     */
    private $uuidMigrationDataCollector;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScopere8e811afab72\Rector\Doctrine\Collector\UuidMigrationDataCollector $uuidMigrationDataCollector)
    {
        $this->uuidMigrationDataCollector = $uuidMigrationDataCollector;
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function run() : void
    {
        $this->generatePropertiesJsonWithFileName('uuid-migration-new-column-properties.json', $this->uuidMigrationDataCollector->getColumnPropertiesByClass());
        $this->generatePropertiesJsonWithFileName('uuid-migration-new-relation-properties.json', $this->uuidMigrationDataCollector->getRelationPropertiesByClass());
    }
    /**
     * @param mixed[] $data
     */
    private function generatePropertiesJsonWithFileName(string $fileName, array $data) : void
    {
        if ($data === []) {
            return;
        }
        $jsonContent = \_PhpScopere8e811afab72\Nette\Utils\Json::encode(['new_columns_by_class' => $data], \_PhpScopere8e811afab72\Nette\Utils\Json::PRETTY);
        $filePath = \getcwd() . '/' . $fileName;
        $this->smartFileSystem->dumpFile($filePath, $jsonContent);
        $message = \sprintf('See freshly created "%s" file for changes on entities', $fileName);
        $this->symfonyStyle->warning($message);
    }
}
