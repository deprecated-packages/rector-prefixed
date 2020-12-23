<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PostRector\Rector;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\Node\NameImporter;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockNameImporter;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class NameImportingPostRector extends \_PhpScoper0a2ac50786fa\Rector\PostRector\Rector\AbstractPostRector
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var NameImporter
     */
    private $nameImporter;
    /**
     * @var DocBlockNameImporter
     */
    private $docBlockNameImporter;
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoper0a2ac50786fa\Rector\CodingStyle\Node\NameImporter $nameImporter, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockNameImporter $docBlockNameImporter)
    {
        $this->parameterProvider = $parameterProvider;
        $this->nameImporter = $nameImporter;
        $this->docBlockNameImporter = $docBlockNameImporter;
    }
    public function enterNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $autoImportNames = $this->parameterProvider->provideParameter(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES);
        if (!$autoImportNames) {
            return null;
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
            return $this->nameImporter->importName($node);
        }
        $importDocBlocks = (bool) $this->parameterProvider->provideParameter(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS);
        if (!$importDocBlocks) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $hasChanged = $this->docBlockNameImporter->importNames($phpDocInfo, $node);
        if (!$hasChanged) {
            return null;
        }
        return $node;
    }
    public function getPriority() : int
    {
        return 600;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Imports fully qualified class names in parameter types, return types, extended classes, implemented, interfaces and even docblocks', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$someClass = new \Some\FullyQualified\SomeClass();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Some\FullyQualified\SomeClass;

$someClass = new SomeClass();
CODE_SAMPLE
)]);
    }
}
