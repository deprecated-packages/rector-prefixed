<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Comment\CommentsMerger;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTransformer;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see https://medium.com/tech-tajawal/use-memory-gently-with-yield-in-php-7e62e2480b8d
 * @see https://3v4l.org/5PJid
 *
 * @see \Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\ReturnArrayClassMethodToYieldRectorTest
 */
final class ReturnArrayClassMethodToYieldRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHODS_TO_YIELDS = 'methods_to_yields';
    /**
     * @var ReturnArrayClassMethodToyield[]
     */
    private $methodsToYields = [];
    /**
     * @var NodeTransformer
     */
    private $nodeTransformer;
    /**
     * @var CommentsMerger
     */
    private $commentsMerger;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTransformer $nodeTransformer, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Comment\CommentsMerger $commentsMerger)
    {
        $this->nodeTransformer = $nodeTransformer;
        $this->commentsMerger = $commentsMerger;
        // default values
        $this->methodsToYields = [new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'provideData'), new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'provideData*'), new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'dataProvider'), new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'dataProvider*')];
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns array return to yield return in specific type and method', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return ['event' => 'callback'];
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        yield 'event' => 'callback';
    }
}
CODE_SAMPLE
, [self::METHODS_TO_YIELDS => [new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('EventSubscriberInterface', 'getSubscribedEvents')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $hasChanged = \false;
        foreach ($this->methodsToYields as $methodToYield) {
            if (!$this->isObjectType($node, $methodToYield->getType())) {
                continue;
            }
            if (!$this->isName($node, $methodToYield->getMethod())) {
                continue;
            }
            $arrayNode = $this->collectReturnArrayNodesFromClassMethod($node);
            if ($arrayNode === null) {
                continue;
            }
            $this->transformArrayToYieldsOnMethodNode($node, $arrayNode);
            $this->commentsMerger->keepParent($node, $arrayNode);
            $hasChanged = \true;
        }
        if (!$hasChanged) {
            return null;
        }
        return $node;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $methodsToYields = $configuration[self::METHODS_TO_YIELDS] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($methodsToYields, \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield::class);
        $this->methodsToYields = $methodsToYields;
    }
    private function collectReturnArrayNodesFromClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_
    {
        if ($classMethod->stmts === null) {
            return null;
        }
        foreach ($classMethod->stmts as $statement) {
            if ($statement instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
                if (!$statement->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
                    continue;
                }
                return $statement->expr;
            }
        }
        return null;
    }
    private function transformArrayToYieldsOnMethodNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_ $array) : void
    {
        $yieldNodes = $this->nodeTransformer->transformArrayToYields($array);
        // remove whole return node
        $parentNode = $array->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->removeReturnTag($classMethod);
        // change return typehint
        $classMethod->returnType = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified(\Iterator::class);
        foreach ((array) $classMethod->stmts as $key => $classMethodStmt) {
            if (!$classMethodStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
                continue;
            }
            unset($classMethod->stmts[$key]);
        }
        $classMethod->stmts = \array_merge((array) $classMethod->stmts, $yieldNodes);
    }
    private function removeReturnTag(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $phpDocInfo->removeByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
}
