<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\DelegateExceptionArgumentsRector\DelegateExceptionArgumentsRectorTest
 */
final class DelegateExceptionArgumentsRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var array<string, string>
     */
    private const OLD_TO_NEW_METHOD = ['setExpectedException' => 'expectExceptionMessage', 'setExpectedExceptionRegExp' => 'expectExceptionMessageRegExp'];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Takes `setExpectedException()` 2nd and next arguments to own methods in PHPUnit.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->setExpectedException(Exception::class, "Message", "CODE");', <<<'CODE_SAMPLE'
$this->setExpectedException(Exception::class);
$this->expectExceptionMessage('Message');
$this->expectExceptionCode('CODE');
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $oldMethodNames = \array_keys(self::OLD_TO_NEW_METHOD);
        if (!$this->isPHPUnitMethodNames($node, $oldMethodNames)) {
            return null;
        }
        if (isset($node->args[1])) {
            /** @var Identifier $identifierNode */
            $identifierNode = $node->name;
            $oldMethodName = $identifierNode->name;
            $call = $this->createPHPUnitCallWithName($node, self::OLD_TO_NEW_METHOD[$oldMethodName]);
            $call->args[] = $node->args[1];
            $this->addNodeAfterNode($call, $node);
            unset($node->args[1]);
            // add exception code method call
            if (isset($node->args[2])) {
                $call = $this->createPHPUnitCallWithName($node, 'expectExceptionCode');
                $call->args[] = $node->args[2];
                $this->addNodeAfterNode($call, $node);
                unset($node->args[2]);
            }
        }
        $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('expectException');
        return $node;
    }
}
