<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use Rector\BetterPhpDocParser\Comment\CommentsMerger;
use Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\NodeTransformer;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210317\Webmozart\Assert\Assert;
/**
 * @see https://medium.com/tech-tajawal/use-memory-gently-with-yield-in-php-7e62e2480b8d
 * @see https://3v4l.org/5PJid
 *
 * @see \Rector\Tests\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\ReturnArrayClassMethodToYieldRectorTest
 */
final class ReturnArrayClassMethodToYieldRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    /**
     * @param \Rector\Core\PhpParser\NodeTransformer $nodeTransformer
     * @param \Rector\BetterPhpDocParser\Comment\CommentsMerger $commentsMerger
     */
    public function __construct($nodeTransformer, $commentsMerger)
    {
        $this->nodeTransformer = $nodeTransformer;
        $this->commentsMerger = $commentsMerger;
        // default values
        $this->methodsToYields = [new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('PHPUnit\\Framework\\TestCase', 'provideData'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('PHPUnit\\Framework\\TestCase', 'provideData*'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('PHPUnit\\Framework\\TestCase', 'dataProvider'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('PHPUnit\\Framework\\TestCase', 'dataProvider*')];
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns array return to yield return in specific type and method', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::METHODS_TO_YIELDS => [new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('EventSubscriberInterface', 'getSubscribedEvents')]])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        $hasChanged = \false;
        foreach ($this->methodsToYields as $methodToYield) {
            if (!$this->isObjectType($node, $methodToYield->getObjectType())) {
                continue;
            }
            if (!$this->isName($node, $methodToYield->getMethod())) {
                continue;
            }
            $arrayNode = $this->collectReturnArrayNodesFromClassMethod($node);
            if (!$arrayNode instanceof \PhpParser\Node\Expr\Array_) {
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
    public function configure($configuration) : void
    {
        $methodsToYields = $configuration[self::METHODS_TO_YIELDS] ?? [];
        \RectorPrefix20210317\Webmozart\Assert\Assert::allIsInstanceOf($methodsToYields, \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield::class);
        $this->methodsToYields = $methodsToYields;
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function collectReturnArrayNodesFromClassMethod($classMethod) : ?\PhpParser\Node\Expr\Array_
    {
        if ($classMethod->stmts === null) {
            return null;
        }
        foreach ($classMethod->stmts as $statement) {
            if ($statement instanceof \PhpParser\Node\Stmt\Return_) {
                $returnedExpr = $statement->expr;
                if (!$returnedExpr instanceof \PhpParser\Node\Expr\Array_) {
                    continue;
                }
                return $returnedExpr;
            }
        }
        return null;
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     * @param \PhpParser\Node\Expr\Array_ $array
     */
    private function transformArrayToYieldsOnMethodNode($classMethod, $array) : void
    {
        $yieldNodes = $this->nodeTransformer->transformArrayToYields($array);
        // remove whole return node
        $parentNode = $array->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->removeReturnTag($classMethod);
        // change return typehint
        $classMethod->returnType = new \PhpParser\Node\Name\FullyQualified('Iterator');
        foreach ((array) $classMethod->stmts as $key => $classMethodStmt) {
            if (!$classMethodStmt instanceof \PhpParser\Node\Stmt\Return_) {
                continue;
            }
            unset($classMethod->stmts[$key]);
        }
        $classMethod->stmts = \array_merge((array) $classMethod->stmts, $yieldNodes);
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function removeReturnTag($classMethod) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $phpDocInfo->removeByType(\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
}
