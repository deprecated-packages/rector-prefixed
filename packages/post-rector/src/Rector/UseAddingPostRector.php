<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Rector;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Application\UseImportsAdder;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Application\UseImportsRemover;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\UseNodesToAddCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class UseAddingPostRector extends \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Rector\AbstractPostRector
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Application\UseImportsAdder $useImportsAdder, \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Application\UseImportsRemover $useImportsRemover, \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
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
        $namespace = $this->betterNodeFinder->findFirstInstanceOf($nodes, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_::class);
        if ($namespace instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_) {
            // first clean
            $this->useImportsRemover->removeImportsFromNamespace($namespace, $removedShortUses);
            // then add, to prevent adding + removing false positive of same short use
            $this->useImportsAdder->addImportsToNamespace($namespace, $useImportTypes, $functionUseImportTypes);
            return $nodes;
        }
        $firstNode = $nodes[0];
        if ($firstNode instanceof \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
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
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Post Rector that adds use statements', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
    private function getSmartFileInfo(array $nodes) : ?\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo
    {
        foreach ($nodes as $node) {
            /** @var SmartFileInfo|null $smartFileInfo */
            $smartFileInfo = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
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
            if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($useImportType->getClassName(), '\\')) {
                continue;
            }
            $namespacedUseImportTypes[] = $useImportType;
        }
        return $namespacedUseImportTypes;
    }
}
