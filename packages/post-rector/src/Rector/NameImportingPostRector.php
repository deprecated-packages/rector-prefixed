<?php

declare (strict_types=1);
namespace Rector\PostRector\Rector;

use PhpParser\Node;
use PhpParser\Node\Name;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\CodingStyle\Node\NameImporter;
use Rector\Core\Configuration\Option;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockNameImporter;
use RectorPrefix20201231\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
final class NameImportingPostRector extends \Rector\PostRector\Rector\AbstractPostRector
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
    public function __construct(\RectorPrefix20201231\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \Rector\CodingStyle\Node\NameImporter $nameImporter, \Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockNameImporter $docBlockNameImporter)
    {
        $this->parameterProvider = $parameterProvider;
        $this->nameImporter = $nameImporter;
        $this->docBlockNameImporter = $docBlockNameImporter;
    }
    public function enterNode(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $autoImportNames = $this->parameterProvider->provideParameter(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES);
        if (!$autoImportNames) {
            return null;
        }
        if ($node instanceof \PhpParser\Node\Name) {
            return $this->nameImporter->importName($node);
        }
        $importDocBlocks = (bool) $this->parameterProvider->provideParameter(\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS);
        if (!$importDocBlocks) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Imports fully qualified class names in parameter types, return types, extended classes, implemented, interfaces and even docblocks', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$someClass = new \Some\FullyQualified\SomeClass();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Some\FullyQualified\SomeClass;

$someClass = new SomeClass();
CODE_SAMPLE
)]);
    }
}
