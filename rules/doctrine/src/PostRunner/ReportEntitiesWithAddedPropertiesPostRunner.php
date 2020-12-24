<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\PostRunner;

use _PhpScoperb75b35f52b74\Nette\Utils\Json;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\PostRunnerInterface;
use _PhpScoperb75b35f52b74\Rector\Doctrine\Collector\UuidMigrationDataCollector;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @deprecated Replace with interface. Remove whole event system to keep 1 less pattern for same thing
 */
final class ReportEntitiesWithAddedPropertiesPostRunner implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\PostRunnerInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoperb75b35f52b74\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoperb75b35f52b74\Rector\Doctrine\Collector\UuidMigrationDataCollector $uuidMigrationDataCollector)
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
        $jsonContent = \_PhpScoperb75b35f52b74\Nette\Utils\Json::encode(['new_columns_by_class' => $data], \_PhpScoperb75b35f52b74\Nette\Utils\Json::PRETTY);
        $filePath = \getcwd() . '/' . $fileName;
        $this->smartFileSystem->dumpFile($filePath, $jsonContent);
        $message = \sprintf('See freshly created "%s" file for changes on entities', $fileName);
        $this->symfonyStyle->warning($message);
    }
}
