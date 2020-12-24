<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/4160
 * @see https://github.com/symfony/symfony/pull/29685/files
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\UseSpecificWillMethodRector\UseSpecificWillMethodRectorTest
 */
final class UseSpecificWillMethodRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var string[]
     */
    private const NESTED_METHOD_TO_RENAME_MAP = ['returnArgument' => 'willReturnArgument', 'returnCallback' => 'willReturnCallback', 'returnSelf' => 'willReturnSelf', 'returnValue' => 'willReturn', 'returnValueMap' => 'willReturnMap', 'throwException' => 'willThrowException'];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes ->will($this->xxx()) to one specific method', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        $callerNode = $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall ? $node->class : $node->var;
        if (!$this->isObjectType($callerNode, '_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\MockObject\\Builder\\InvocationMocker')) {
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
    private function processWithCall(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($node->args as $i => $argNode) {
            if (!$argNode->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
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
    private function processWillCall(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$node->args[0]->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        $nestedMethodCall = $node->args[0]->value;
        foreach (self::NESTED_METHOD_TO_RENAME_MAP as $oldMethodName => $newParentMethodName) {
            if (!$this->isName($nestedMethodCall->name, $oldMethodName)) {
                continue;
            }
            $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($newParentMethodName);
            // move args up
            $node->args = $nestedMethodCall->args;
            return $node;
        }
        return null;
    }
}
