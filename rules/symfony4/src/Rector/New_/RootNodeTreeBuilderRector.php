<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony4\Rector\New_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/pull/27476
 * @see \Rector\Symfony4\Tests\Rector\New_\RootNodeTreeBuilderRector\RootNodeTreeBuilderRectorTest
 */
final class RootNodeTreeBuilderRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes  Process string argument to an array', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

$treeBuilder = new TreeBuilder();
$rootNode = $treeBuilder->root('acme_root');
$rootNode->someCall();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

$treeBuilder = new TreeBuilder('acme_root');
$rootNode = $treeBuilder->getRootNode();
$rootNode->someCall();
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isObjectType($node->class, '_PhpScopere8e811afab72\\Symfony\\Component\\Config\\Definition\\Builder\\TreeBuilder')) {
            return null;
        }
        if (isset($node->args[1])) {
            return null;
        }
        /** @var MethodCall|null $rootMethodCallNode */
        $rootMethodCallNode = $this->getRootMethodCallNode($node);
        if ($rootMethodCallNode === null) {
            return null;
        }
        $rootNameNode = $rootMethodCallNode->args[0]->value;
        if (!$rootNameNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return null;
        }
        [$node->args, $rootMethodCallNode->args] = [$rootMethodCallNode->args, $node->args];
        $rootMethodCallNode->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('getRootNode');
        return $node;
    }
    private function getRootMethodCallNode(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $expression = $new->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($expression === null) {
            return null;
        }
        $nextExpression = $expression->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if ($nextExpression === null) {
            return null;
        }
        return $this->betterNodeFinder->findFirst([$nextExpression], function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
                return \false;
            }
            if (!$this->isObjectType($node->var, '_PhpScopere8e811afab72\\Symfony\\Component\\Config\\Definition\\Builder\\TreeBuilder')) {
                return \false;
            }
            if (!$this->isName($node->name, 'root')) {
                return \false;
            }
            return isset($node->args[0]);
        });
    }
}
