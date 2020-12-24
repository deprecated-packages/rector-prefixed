<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipper;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\UseNodesToAddCollector;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
final class DocBlockNameImporter
{
    /**
     * @var bool
     */
    private $hasPhpDocChanged = \false;
    /**
     * @var PhpDocNodeTraverser
     */
    private $phpDocNodeTraverser;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var ClassNameImportSkipper
     */
    private $classNameImportSkipper;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var UseNodesToAddCollector
     */
    private $useNodesToAddCollector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipper $classNameImportSkipper, \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoperb75b35f52b74\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->classNameImportSkipper = $classNameImportSkipper;
        $this->parameterProvider = $parameterProvider;
        $this->useNodesToAddCollector = $useNodesToAddCollector;
    }
    public function importNames(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoperb75b35f52b74\PhpParser\Node $phpParserNode) : bool
    {
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        $this->hasPhpDocChanged = \false;
        $this->phpDocNodeTraverser->traverseWithCallable($attributeAwarePhpDocNode, '', function (\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node $docNode) use($phpParserNode) : PhpDocParserNode {
            if (!$docNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                return $docNode;
            }
            $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($docNode, $phpParserNode);
            if (!$staticType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType) {
                return $docNode;
            }
            $importShortClasses = $this->parameterProvider->provideParameter(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::IMPORT_SHORT_CLASSES);
            // Importing root namespace classes (like \DateTime) is optional
            if (!$importShortClasses && \substr_count($staticType->getClassName(), '\\') === 0) {
                return $docNode;
            }
            return $this->processFqnNameImport($phpParserNode, $docNode, $staticType);
        });
        return $this->hasPhpDocChanged;
    }
    private function processFqnNameImport(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $identifierTypeNode, \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Node
    {
        if ($this->classNameImportSkipper->shouldSkipNameForFullyQualifiedObjectType($node, $fullyQualifiedObjectType)) {
            return $identifierTypeNode;
        }
        // should skip because its already used
        if ($this->useNodesToAddCollector->isShortImported($node, $fullyQualifiedObjectType)) {
            if ($this->useNodesToAddCollector->isImportShortable($node, $fullyQualifiedObjectType)) {
                $identifierTypeNode->name = $fullyQualifiedObjectType->getShortName();
                $this->hasPhpDocChanged = \true;
            }
            return $identifierTypeNode;
        }
        $shortenedIdentifierTypeNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($fullyQualifiedObjectType->getShortName());
        $this->hasPhpDocChanged = \true;
        $this->useNodesToAddCollector->addUseImport($node, $fullyQualifiedObjectType);
        return $shortenedIdentifierTypeNode;
    }
}
