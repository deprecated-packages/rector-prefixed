<?php

declare (strict_types=1);
namespace Rector\Utils\DoctrineAnnotationParserSyncer\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Rector\AbstractRector;
use Rector\DoctrineAnnotationGenerated\DataCollector\ResolvedConstantStaticCollector;
use Rector\Utils\DoctrineAnnotationParserSyncer\Contract\Rector\ClassSyncerRectorInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineAnnotationGenerated\ConstantPreservingDocParser::Constant()
 */
final class LogIdentifierAndResolverValueInConstantClassMethodRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Utils\DoctrineAnnotationParserSyncer\Contract\Rector\ClassSyncerRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isInClassNamed($node, '_PhpScopera143bcca66cb\\Doctrine\\Common\\Annotations\\DocParser')) {
            return null;
        }
        if (!$this->isName($node->name, 'Constant')) {
            return null;
        }
        // 1. store original value right in the start
        $firstStmt = $node->stmts[0];
        unset($node->stmts[0]);
        $assignExpression = $this->createAssignOriginalIdentifierExpression();
        $node->stmts = \array_merge([$firstStmt], [$assignExpression], (array) $node->stmts);
        // 2. record value in each return
        $this->traverseNodesWithCallable((array) $node->stmts, function (\PhpParser\Node $node) : ?Return_ {
            if (!$node instanceof \PhpParser\Node\Stmt\Return_) {
                return null;
            }
            if ($node->expr === null) {
                return null;
            }
            // assign resolved value to temporary variable
            $resolvedValueVariable = new \PhpParser\Node\Expr\Variable('resolvedValue');
            $assign = new \PhpParser\Node\Expr\Assign($resolvedValueVariable, $node->expr);
            $assignExpression = new \PhpParser\Node\Stmt\Expression($assign);
            $this->addNodeBeforeNode($assignExpression, $node);
            // log the value in static call
            $originalIdentifier = new \PhpParser\Node\Expr\Variable('originalIdentifier');
            $staticCallExpression = $this->createStaticCallExpression($originalIdentifier, $resolvedValueVariable);
            $this->addNodeBeforeNode($staticCallExpression, $node);
            $node->expr = $resolvedValueVariable;
            return $node;
        });
        return $node;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Log original and changed constant value', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
namespace Doctrine\Common\Annotations;

class AnnotationReader
{
    public function Constant()
    {
        // ...
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
namespace Doctrine\Common\Annotations;

class AnnotationReader
{
    public function Constant()
    {
        $identifier = $this->Identifier();
        $originalIdentifier = $identifier;
        // ...
    }
}
CODE_SAMPLE
)]);
    }
    private function createAssignOriginalIdentifierExpression() : \PhpParser\Node\Stmt\Expression
    {
        $originalIdentifier = new \PhpParser\Node\Expr\Variable('originalIdentifier');
        $identifier = new \PhpParser\Node\Expr\Variable('identifier');
        $assign = new \PhpParser\Node\Expr\Assign($originalIdentifier, $identifier);
        return new \PhpParser\Node\Stmt\Expression($assign);
    }
    private function createStaticCallExpression(\PhpParser\Node\Expr\Variable $identifierVariable, \PhpParser\Node\Expr\Variable $resolvedVariable) : \PhpParser\Node\Stmt\Expression
    {
        $args = [new \PhpParser\Node\Arg($identifierVariable), new \PhpParser\Node\Arg($resolvedVariable)];
        $staticCall = new \PhpParser\Node\Expr\StaticCall(new \PhpParser\Node\Name\FullyQualified(\Rector\DoctrineAnnotationGenerated\DataCollector\ResolvedConstantStaticCollector::class), 'collect', $args);
        return new \PhpParser\Node\Stmt\Expression($staticCall);
    }
}
