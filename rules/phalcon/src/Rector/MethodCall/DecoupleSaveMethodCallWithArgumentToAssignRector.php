<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Phalcon\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2571
 *
 * @see \Rector\Phalcon\Tests\Rector\MethodCall\DecoupleSaveMethodCallWithArgumentToAssignRector\DecoupleSaveMethodCallWithArgumentToAssignRectorTest
 */
final class DecoupleSaveMethodCallWithArgumentToAssignRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Decouple Phalcon\\Mvc\\Model::save() with argument to assign()', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(\Phalcon\Mvc\Model $model, $data)
    {
        $model->save($data);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(\Phalcon\Mvc\Model $model, $data)
    {
        $model->save();
        $model->assign($data);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScoper0a6b37af0871\\Phalcon\\Mvc\\Model')) {
            return null;
        }
        if (!$this->isName($node->name, 'save')) {
            return null;
        }
        if ($node->args === []) {
            return null;
        }
        $assignMethodCall = $this->createMethodCall($node->var, 'assign');
        $assignMethodCall->args = $node->args;
        $node->args = [];
        $this->addNodeAfterNode($assignMethodCall, $node);
        return $node;
    }
}
