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
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/4160
 * @see https://github.com/symfony/symfony/pull/29685/files
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\UseSpecificWillMethodRector\UseSpecificWillMethodRectorTest
 */
final class UseSpecificWillMethodRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var string[]
     */
    private const NESTED_METHOD_TO_RENAME_MAP = ['returnArgument' => 'willReturnArgument', 'returnCallback' => 'willReturnCallback', 'returnSelf' => 'willReturnSelf', 'returnValue' => 'willReturn', 'returnValueMap' => 'willReturnMap', 'throwException' => 'willThrowException'];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes ->will($this->xxx()) to one specific method', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass extends PHPUnit\Framework\TestCase
{
    public function test()
    {
        $translator = $this->getMockBuilder('Symfony\Component\Translation\TranslatorInterface')->getMock();
        $translator->expects($this->any())
            ->method('trans')
            ->with($this->equalTo('old max {{ max }}!'))
            ->will($this->returnValue('translated max {{ max }}!'));
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass extends PHPUnit\Framework\TestCase
{
    public function test()
    {
        $translator = $this->getMockBuilder('Symfony\Component\Translation\TranslatorInterface')->getMock();
        $translator->expects($this->any())
            ->method('trans')
            ->with('old max {{ max }}!')
            ->willReturnValue('translated max {{ max }}!');
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        $callerNode = $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall ? $node->class : $node->var;
        if (!$this->isObjectType($callerNode, '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\MockObject\\Builder\\InvocationMocker')) {
            return null;
        }
        if ($this->isName($node->name, 'with')) {
            return $this->processWithCall($node);
        }
        if ($this->isName($node->name, 'will')) {
            return $this->processWillCall($node);
        }
        return null;
    }
    /**
     * @param MethodCall|StaticCall $node
     * @return MethodCall|StaticCall
     */
    private function processWithCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($node->args as $i => $argNode) {
            if (!$argNode->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
                continue;
            }
            $methodCall = $argNode->value;
            if (!$this->isName($methodCall->name, 'equalTo')) {
                continue;
            }
            $node->args[$i] = $methodCall->args[0];
        }
        return $node;
    }
    /**
     * @param MethodCall|StaticCall $node
     * @return MethodCall|StaticCall|null
     */
    private function processWillCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node->args[0]->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        $nestedMethodCall = $node->args[0]->value;
        foreach (self::NESTED_METHOD_TO_RENAME_MAP as $oldMethodName => $newParentMethodName) {
            if (!$this->isName($nestedMethodCall->name, $oldMethodName)) {
                continue;
            }
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($newParentMethodName);
            // move args up
            $node->args = $nestedMethodCall->args;
            return $node;
        }
        return null;
    }
}
