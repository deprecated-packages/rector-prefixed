<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\DelegateExceptionArgumentsRector\DelegateExceptionArgumentsRectorTest
 */
final class DelegateExceptionArgumentsRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var array<string, string>
     */
    private const OLD_TO_NEW_METHOD = ['setExpectedException' => 'expectExceptionMessage', 'setExpectedExceptionRegExp' => 'expectExceptionMessageRegExp'];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Takes `setExpectedException()` 2nd and next arguments to own methods in PHPUnit.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->setExpectedException(Exception::class, "Message", "CODE");', <<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
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
        $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier('expectException');
        return $node;
    }
}
