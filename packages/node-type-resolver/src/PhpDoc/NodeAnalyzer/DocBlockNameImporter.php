<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node as PhpDocParserNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipper;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Collector\UseNodesToAddCollector;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a2ac50786fa\Symplify\SimplePhpDocParser\PhpDocNodeTraverser;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipper $classNameImportSkipper, \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoper0a2ac50786fa\Symplify\SimplePhpDocParser\PhpDocNodeTraverser $phpDocNodeTraverser, \_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoper0a2ac50786fa\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
    {
        $this->phpDocNodeTraverser = $phpDocNodeTraverser;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->classNameImportSkipper = $classNameImportSkipper;
        $this->parameterProvider = $parameterProvider;
        $this->useNodesToAddCollector = $useNodesToAddCollector;
    }
    public function importNames(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoper0a2ac50786fa\PhpParser\Node $phpParserNode) : bool
    {
        $attributeAwarePhpDocNode = $phpDocInfo->getPhpDocNode();
        $this->hasPhpDocChanged = \false;
        $this->phpDocNodeTraverser->traverseWithCallable($attributeAwarePhpDocNode, '', function (\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node $docNode) use($phpParserNode) : PhpDocParserNode {
            if (!$docNode instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                return $docNode;
            }
            $staticType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($docNode, $phpParserNode);
            if (!$staticType instanceof \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType) {
                return $docNode;
            }
            $importShortClasses = $this->parameterProvider->provideParameter(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::IMPORT_SHORT_CLASSES);
            // Importing root namespace classes (like \DateTime) is optional
            if (!$importShortClasses && \substr_count($staticType->getClassName(), '\\') === 0) {
                return $docNode;
            }
            return $this->processFqnNameImport($phpParserNode, $docNode, $staticType);
        });
        return $this->hasPhpDocChanged;
    }
    private function processFqnNameImport(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $identifierTypeNode, \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node
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
        $shortenedIdentifierTypeNode = new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($fullyQualifiedObjectType->getShortName());
        $this->hasPhpDocChanged = \true;
        $this->useNodesToAddCollector->addUseImport($node, $fullyQualifiedObjectType);
        return $shortenedIdentifierTypeNode;
    }
}
