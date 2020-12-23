<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php70\Rector\FuncCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php70\Tests\Rector\FuncCall\CallUserMethodRector\CallUserMethodRectorTest
 */
final class CallUserMethodRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const OLD_TO_NEW_FUNCTIONS = ['call_user_method' => 'call_user_func', 'call_user_method_array' => 'call_user_func_array'];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes call_user_method()/call_user_method_array() to call_user_func()/call_user_func_array()', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('call_user_method($method, $obj, "arg1", "arg2");', 'call_user_func(array(&$obj, "method"), "arg1", "arg2");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $oldFunctionNames = \array_keys(self::OLD_TO_NEW_FUNCTIONS);
        if (!$this->isNames($node, $oldFunctionNames)) {
            return null;
        }
        $newName = self::OLD_TO_NEW_FUNCTIONS[$this->getName($node)];
        $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($newName);
        $oldArgs = $node->args;
        unset($node->args[1]);
        $newArgs = [$this->createArg([$oldArgs[1]->value, $oldArgs[0]->value])];
        unset($oldArgs[0]);
        unset($oldArgs[1]);
        $node->args = $this->appendArgs($newArgs, $oldArgs);
        return $node;
    }
}
