<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTransformer;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://medium.com/tech-tajawal/use-memory-gently-with-yield-in-php-7e62e2480b8d
 * @see https://3v4l.org/5PJid
 *
 * @see \Rector\CodingStyle\Tests\Rector\ClassMethod\YieldClassMethodToArrayClassMethodRector\YieldClassMethodToArrayClassMethodRectorTest
 */
final class YieldClassMethodToArrayClassMethodRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHODS_BY_TYPE = '$methodsByType';
    /**
     * @var string[][]
     */
    private $methodsByType = [];
    /**
     * @var NodeTransformer
     */
    private $nodeTransformer;
    /**
     * @param string[][] $methodsByType
     */
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTransformer $nodeTransformer, array $methodsByType = [])
    {
        $this->methodsByType = $methodsByType;
        $this->nodeTransformer = $nodeTransformer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns yield return to array return in specific type and method', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        yield 'event' => 'callback';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return ['event' => 'callback'];
    }
}
CODE_SAMPLE
, [self::METHODS_BY_TYPE => ['EventSubscriberInterface' => ['getSubscribedEvents']]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->methodsByType as $type => $methods) {
            if (!$this->isObjectType($node, $type)) {
                continue;
            }
            foreach ($methods as $method) {
                if (!$this->isName($node, $method)) {
                    continue;
                }
                $yieldNodes = $this->collectYieldNodesFromClassMethod($node);
                if ($yieldNodes === []) {
                    continue;
                }
                $arrayNode = $this->nodeTransformer->transformYieldsToArray($yieldNodes);
                $this->removeNodes($yieldNodes);
                $node->returnType = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('array');
                $returnExpression = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($arrayNode);
                $node->stmts = \array_merge((array) $node->stmts, [$returnExpression]);
            }
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->methodsByType = $configuration[self::METHODS_BY_TYPE] ?? [];
    }
    /**
     * @return Yield_[]
     */
    private function collectYieldNodesFromClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $yieldNodes = [];
        if ($classMethod->stmts === null) {
            return [];
        }
        foreach ($classMethod->stmts as $statement) {
            if (!$statement instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            if ($statement->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_) {
                $yieldNodes[] = $statement->expr;
            }
        }
        return $yieldNodes;
    }
}
