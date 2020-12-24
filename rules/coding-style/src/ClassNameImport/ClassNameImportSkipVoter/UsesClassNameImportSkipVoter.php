<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\PostRector\Collector\UseNodesToAddCollector;
/**
 * This prevents importing:
 * - App\Some\Product
 *
 * if there is already:
 * - use App\Another\Product
 */
final class UsesClassNameImportSkipVoter implements \_PhpScopere8e811afab72\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var UseNodesToAddCollector
     */
    private $useNodesToAddCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
    {
        $this->useNodesToAddCollector = $useNodesToAddCollector;
    }
    public function shouldSkip(\_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScopere8e811afab72\PhpParser\Node $node) : bool
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
