<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\ClassConst;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassConst;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use Rector\Core\PhpParser\Node\Manipulator\ClassConstManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\ClassConst\RemoveUnusedClassConstantRector\RemoveUnusedClassConstantRectorTest
 */
final class RemoveUnusedClassConstantRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var ClassConstManipulator
     */
    private $classConstManipulator;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\ClassConstManipulator $classConstManipulator)
    {
        $this->classConstManipulator = $classConstManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused class constants', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    private const SOME_CONST = 'dead';

    public function run()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassConst::class];
    }
    /**
     * @param ClassConst $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var string|null $class */
        $class = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($class === null) {
            return null;
        }
        $nodeRepositoryFindInterface = $this->nodeRepository->findInterface($class);
        // 0. constants declared in interfaces have to be public
        if ($nodeRepositoryFindInterface !== null) {
            $this->makePublic($node);
            return $node;
        }
        /** @var string $constant */
        $constant = $this->getName($node);
        $directUseClasses = $this->nodeRepository->findDirectClassConstantFetches($class, $constant);
        if ($directUseClasses !== []) {
            return null;
        }
        $indirectUseClasses = $this->nodeRepository->findIndirectClassConstantFetches($class, $constant);
        if ($indirectUseClasses !== []) {
            return null;
        }
        $this->removeNode($node);
        return null;
    }
    /**
     * @param ClassConst $node
     */
    private function shouldSkip(\PhpParser\Node $node) : bool
    {
        if ($this->isOpenSourceProjectType()) {
            return \true;
        }
        if (\count($node->consts) !== 1) {
            return \true;
        }
        if ($this->classConstManipulator->isEnum($node)) {
            return \true;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        return $phpDocInfo->hasByName('api');
    }
}
