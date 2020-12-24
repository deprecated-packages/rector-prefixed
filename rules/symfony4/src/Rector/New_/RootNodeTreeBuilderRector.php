<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony4\Rector\New_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/pull/27476
 * @see \Rector\Symfony4\Tests\Rector\New_\RootNodeTreeBuilderRector\RootNodeTreeBuilderRectorTest
 */
final class RootNodeTreeBuilderRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes  Process string argument to an array', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isObjectType($node->class, '_PhpScoper0a6b37af0871\\Symfony\\Component\\Config\\Definition\\Builder\\TreeBuilder')) {
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
        if (!$rootNameNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            return null;
        }
        [$node->args, $rootMethodCallNode->args] = [$rootMethodCallNode->args, $node->args];
        $rootMethodCallNode->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier('getRootNode');
        return $node;
    }
    private function getRootMethodCallNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_ $new) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $expression = $new->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($expression === null) {
            return null;
        }
        $nextExpression = $expression->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if ($nextExpression === null) {
            return null;
        }
        return $this->betterNodeFinder->findFirst([$nextExpression], function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
                return \false;
            }
            if (!$this->isObjectType($node->var, '_PhpScoper0a6b37af0871\\Symfony\\Component\\Config\\Definition\\Builder\\TreeBuilder')) {
                return \false;
            }
            if (!$this->isName($node->name, 'root')) {
                return \false;
            }
            return isset($node->args[0]);
        });
    }
}
