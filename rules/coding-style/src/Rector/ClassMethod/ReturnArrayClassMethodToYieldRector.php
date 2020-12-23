<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\Rector\ClassMethod;

use Iterator;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Comment\CommentsMerger;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTransformer;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Webmozart\Assert\Assert;
/**
 * @see https://medium.com/tech-tajawal/use-memory-gently-with-yield-in-php-7e62e2480b8d
 * @see https://3v4l.org/5PJid
 *
 * @see \Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\ReturnArrayClassMethodToYieldRectorTest
 */
final class ReturnArrayClassMethodToYieldRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTransformer $nodeTransformer, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Comment\CommentsMerger $commentsMerger)
    {
        $this->nodeTransformer = $nodeTransformer;
        $this->commentsMerger = $commentsMerger;
        // default values
        $this->methodsToYields = [new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'provideData'), new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'provideData*'), new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'dataProvider'), new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'dataProvider*')];
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns array return to yield return in specific type and method', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::METHODS_TO_YIELDS => [new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('EventSubscriberInterface', 'getSubscribedEvents')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
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
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::allIsInstanceOf($methodsToYields, \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield::class);
        $this->methodsToYields = $methodsToYields;
    }
    private function collectReturnArrayNodesFromClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_
    {
        if ($classMethod->stmts === null) {
            return null;
        }
        foreach ($classMethod->stmts as $statement) {
            if ($statement instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
                if (!$statement->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
                    continue;
                }
                return $statement->expr;
            }
        }
        return null;
    }
    private function transformArrayToYieldsOnMethodNode(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_ $array) : void
    {
        $yieldNodes = $this->nodeTransformer->transformArrayToYields($array);
        // remove whole return node
        $parentNode = $array->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->removeReturnTag($classMethod);
        // change return typehint
        $classMethod->returnType = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified(\Iterator::class);
        foreach ((array) $classMethod->stmts as $key => $classMethodStmt) {
            if (!$classMethodStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
                continue;
            }
            unset($classMethod->stmts[$key]);
        }
        $classMethod->stmts = \array_merge((array) $classMethod->stmts, $yieldNodes);
    }
    private function removeReturnTag(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $phpDocInfo->removeByType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
}
