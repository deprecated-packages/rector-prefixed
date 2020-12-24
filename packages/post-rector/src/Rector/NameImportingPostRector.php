<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PostRector\Rector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Node\NameImporter;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockNameImporter;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class NameImportingPostRector extends \_PhpScoperb75b35f52b74\Rector\PostRector\Rector\AbstractPostRector
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
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoperb75b35f52b74\Rector\CodingStyle\Node\NameImporter $nameImporter, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockNameImporter $docBlockNameImporter)
    {
        $this->parameterProvider = $parameterProvider;
        $this->nameImporter = $nameImporter;
        $this->docBlockNameImporter = $docBlockNameImporter;
    }
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $autoImportNames = $this->parameterProvider->provideParameter(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES);
        if (!$autoImportNames) {
            return null;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return $this->nameImporter->importName($node);
        }
        $importDocBlocks = (bool) $this->parameterProvider->provideParameter(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS);
        if (!$importDocBlocks) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Imports fully qualified class names in parameter types, return types, extended classes, implemented, interfaces and even docblocks', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$someClass = new \Some\FullyQualified\SomeClass();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Some\FullyQualified\SomeClass;

$someClass = new SomeClass();
CODE_SAMPLE
)]);
    }
}
