<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\UseNodesToAddCollector;
/**
 * This prevents importing:
 * - App\Some\Product
 *
 * if there is already:
 * - use App\Another\Product
 */
final class UsesClassNameImportSkipVoter implements \_PhpScoperb75b35f52b74\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var UseNodesToAddCollector
     */
    private $useNodesToAddCollector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
    {
        $this->useNodesToAddCollector = $useNodesToAddCollector;
    }
    public function shouldSkip(\_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $useImportTypes = $this->useNodesToAddCollector->getUseImportTypesByNode($node);
        foreach ($useImportTypes as $useImportType) {
            if (!$useImportType->equals($fullyQualifiedObjectType) && $useImportType->areShortNamesEqual($fullyQualifiedObjectType)) {
                return \true;
            }
            if ($useImportType->equals($fullyQualifiedObjectType)) {
                return \false;
            }
        }
        return \false;
    }
}
