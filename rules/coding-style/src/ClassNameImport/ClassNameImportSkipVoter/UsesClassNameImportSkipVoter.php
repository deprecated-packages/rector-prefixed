<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a6b37af0871\Rector\PostRector\Collector\UseNodesToAddCollector;
/**
 * This prevents importing:
 * - App\Some\Product
 *
 * if there is already:
 * - use App\Another\Product
 */
final class UsesClassNameImportSkipVoter implements \_PhpScoper0a6b37af0871\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var UseNodesToAddCollector
     */
    private $useNodesToAddCollector;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
    {
        $this->useNodesToAddCollector = $useNodesToAddCollector;
    }
    public function shouldSkip(\_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
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
