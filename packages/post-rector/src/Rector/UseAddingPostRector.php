<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PostRector\Rector;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\Rector\CodingStyle\Application\UseImportsAdder;
use _PhpScopere8e811afab72\Rector\CodingStyle\Application\UseImportsRemover;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\PostRector\Collector\UseNodesToAddCollector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class UseAddingPostRector extends \_PhpScopere8e811afab72\Rector\PostRector\Rector\AbstractPostRector
{
    /**
     * @var UseImportsAdder
     */
    private $useImportsAdder;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var UseImportsRemover
     */
    private $useImportsRemover;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var UseNodesToAddCollector
     */
    private $useNodesToAddCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \_PhpScopere8e811afab72\Rector\CodingStyle\Application\UseImportsAdder $useImportsAdder, \_PhpScopere8e811afab72\Rector\CodingStyle\Application\UseImportsRemover $useImportsRemover, \_PhpScopere8e811afab72\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
    {
        $this->useImportsAdder = $useImportsAdder;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->useImportsRemover = $useImportsRemover;
        $this->typeFactory = $typeFactory;
        $this->useNodesToAddCollector = $useNodesToAddCollector;
    }
    /**
     * @param Stmt[] $nodes
     * @return Stmt[]
     */
    public function beforeTraverse(array $nodes) : array
    {
        // no nodes → just return
        if ($nodes === []) {
            return $nodes;
        }
        $smartFileInfo = $this->getSmartFileInfo($nodes);
        if ($smartFileInfo === null) {
            return $nodes;
        }
        $useImportTypes = $this->useNodesToAddCollector->getObjectImportsByFileInfo($smartFileInfo);
        $functionUseImportTypes = $this->useNodesToAddCollector->getFunctionImportsByFileInfo($smartFileInfo);
        $removedShortUses = $this->useNodesToAddCollector->getShortUsesByFileInfo($smartFileInfo);
        // nothing to import or remove
        if ($useImportTypes === [] && $functionUseImportTypes === [] && $removedShortUses === []) {
            return $nodes;
        }
        /** @var FullyQualifiedObjectType[] $useImportTypes */
        $useImportTypes = $this->typeFactory->uniquateTypes($useImportTypes);
        $this->useNodesToAddCollector->clear($smartFileInfo);
        // A. has namespace? add under it
        $namespace = $this->betterNodeFinder->findFirstInstanceOf($nodes, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_::class);
        if ($namespace instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
            // first clean
            $this->useImportsRemover->removeImportsFromNamespace($namespace, $removedShortUses);
            // then add, to prevent adding + removing false positive of same short use
            $this->useImportsAdder->addImportsToNamespace($namespace, $useImportTypes, $functionUseImportTypes);
            return $nodes;
        }
        $firstNode = $nodes[0];
        if ($firstNode instanceof \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
            $nodes = $firstNode->stmts;
        }
        // B. no namespace? add in the top
        // first clean
        $nodes = $this->useImportsRemover->removeImportsFromStmts($nodes, $removedShortUses);
        $useImportTypes = $this->filterOutNonNamespacedNames($useImportTypes);
        // then add, to prevent adding + removing false positive of same short use
        return $this->useImportsAdder->addImportsToStmts($nodes, $useImportTypes, $functionUseImportTypes);
    }
    public function getPriority() : int
    {
        // must be after name importing
        return 500;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Post Rector that adds use statements', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$someClass = new SomeClass();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use App\SomeClass;

$someClass = new SomeClass();
CODE_SAMPLE
)]);
    }
    /**
     * @param Node[] $nodes
     */
    private function getSmartFileInfo(array $nodes) : ?\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        foreach ($nodes as $node) {
            /** @var SmartFileInfo|null $smartFileInfo */
            $smartFileInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
            if ($smartFileInfo !== null) {
                return $smartFileInfo;
            }
        }
        return null;
    }
    /**
     * Prevents
     * @param FullyQualifiedObjectType[] $useImportTypes
     * @return FullyQualifiedObjectType[]
     */
    private function filterOutNonNamespacedNames(array $useImportTypes) : array
    {
        $namespacedUseImportTypes = [];
        foreach ($useImportTypes as $useImportType) {
            if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($useImportType->getClassName(), '\\')) {
                continue;
            }
            $namespacedUseImportTypes[] = $useImportType;
        }
        return $namespacedUseImportTypes;
    }
}
