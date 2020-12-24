<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteTesterToPHPUnit;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToAddCollector;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToRemoveCollector;
final class AssertManipulator
{
    /**
     * @see https://github.com/nette/tester/blob/master/src/Framework/Assert.php
     * ↓
     * @see https://github.com/sebastianbergmann/phpunit/blob/master/src/Framework/Assert.php
     * @var string[]
     */
    private const ASSERT_METHODS_REMAP = ['same' => 'assertSame', 'notSame' => 'assertNotSame', 'equal' => 'assertEqual', 'notEqual' => 'assertNotEqual', 'true' => 'assertTrue', 'false' => 'assertFalse', 'null' => 'assertNull', 'notNull' => 'assertNotNull', 'count' => 'assertCount', 'match' => 'assertStringMatchesFormat', 'matchFile' => 'assertStringMatchesFormatFile', 'nan' => 'assertIsNumeric'];
    /**
     * @var string[]
     */
    private const TYPE_TO_METHOD = ['list' => 'assertIsArray', 'array' => 'assertIsArray', 'bool' => 'assertIsBool', 'callable' => 'assertIsCallable', 'float' => 'assertIsFloat', 'int' => 'assertIsInt', 'integer' => 'assertIsInt', 'object' => 'assertIsObject', 'resource' => 'assertIsResource', 'string' => 'assertIsString', 'scalar' => 'assertIsScalar'];
    /**
     * @var string
     */
    private const CONTAINS = 'contains';
    /**
     * @var string
     */
    private const THIS = 'this';
    /**
     * @var string
     */
    private const SELF = 'self';
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var StringTypeAnalyzer
     */
    private $stringTypeAnalyzer;
    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;
    /**
     * @var NodesToAddCollector
     */
    private $nodesToAddCollector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToAddCollector $nodesToAddCollector, \_PhpScoperb75b35f52b74\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer $stringTypeAnalyzer, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->valueResolver = $valueResolver;
        $this->stringTypeAnalyzer = $stringTypeAnalyzer;
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->nodesToAddCollector = $nodesToAddCollector;
    }
    /**
     * @return StaticCall|MethodCall
     */
    public function processStaticCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->nodeNameResolver->isNames($staticCall->name, ['truthy', 'falsey'])) {
            return $this->processTruthyOrFalseyCall($staticCall);
        }
        if ($this->nodeNameResolver->isNames($staticCall->name, [self::CONTAINS, 'notContains'])) {
            $this->processContainsCall($staticCall);
        } elseif ($this->nodeNameResolver->isNames($staticCall->name, ['exception', 'throws'])) {
            $this->processExceptionCall($staticCall);
        } elseif ($this->nodeNameResolver->isName($staticCall->name, 'type')) {
            $this->processTypeCall($staticCall);
        } elseif ($this->nodeNameResolver->isName($staticCall->name, 'noError')) {
            $this->processNoErrorCall($staticCall);
        } else {
            $this->renameAssertMethod($staticCall);
        }
        // self or class, depending on the context
        // prefer $this->assertSame() as more conventional and explicit in class-context
        if (!$this->sholdBeStaticCall($staticCall)) {
            $methodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable(self::THIS), $staticCall->name);
            $methodCall->args = $staticCall->args;
            $methodCall->setAttributes($staticCall->getAttributes());
            $methodCall->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            return $methodCall;
        }
        $staticCall->class = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\Assert');
        return $staticCall;
    }
    /**
     * @return StaticCall|MethodCall
     */
    private function processTruthyOrFalseyCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        $method = $this->nodeNameResolver->isName($staticCall->name, 'truthy') ? 'assertTrue' : 'assertFalse';
        if (!$this->sholdBeStaticCall($staticCall)) {
            $call = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable(self::THIS), $method);
            $call->args = $staticCall->args;
            $call->setAttributes($staticCall->getAttributes());
            $call->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        } else {
            $call = $staticCall;
            $call->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($method);
        }
        if (!$this->nodeTypeResolver->isStaticType($staticCall->args[0]->value, \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType::class)) {
            $call->args[0]->value = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_($staticCall->args[0]->value);
        }
        return $call;
    }
    private function processContainsCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        if ($this->stringTypeAnalyzer->isStringOrUnionStringOnlyType($staticCall->args[1]->value)) {
            $name = $this->nodeNameResolver->isName($staticCall->name, self::CONTAINS) ? 'assertStringContainsString' : 'assertStringNotContainsString';
        } else {
            $name = $this->nodeNameResolver->isName($staticCall->name, self::CONTAINS) ? 'assertContains' : 'assertNotContains';
        }
        $staticCall->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($name);
    }
    private function processExceptionCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        $method = 'expectException';
        // expect exception
        if ($this->sholdBeStaticCall($staticCall)) {
            $expectException = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::SELF), $method);
        } else {
            $expectException = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable(self::THIS), $method);
        }
        $expectException->args[] = $staticCall->args[1];
        $this->nodesToAddCollector->addNodeAfterNode($expectException, $staticCall);
        // expect message
        if (isset($staticCall->args[2])) {
            $this->refactorExpectException($staticCall);
        }
        // expect code
        if (isset($staticCall->args[3])) {
            $this->refactorExpectExceptionCode($staticCall);
        }
        /** @var Closure $closure */
        $closure = $staticCall->args[0]->value;
        $this->nodesToAddCollector->addNodesAfterNode((array) $closure->stmts, $staticCall);
        $this->nodesToRemoveCollector->addNodeToRemove($staticCall);
    }
    private function processTypeCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        $value = $this->valueResolver->getValue($staticCall->args[0]->value);
        if (isset(self::TYPE_TO_METHOD[$value])) {
            $staticCall->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier(self::TYPE_TO_METHOD[$value]);
            unset($staticCall->args[0]);
            $staticCall->args = \array_values($staticCall->args);
        } elseif ($value === 'null') {
            $staticCall->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('assertNull');
            unset($staticCall->args[0]);
            $staticCall->args = \array_values($staticCall->args);
        } else {
            $staticCall->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('assertInstanceOf');
        }
    }
    private function processNoErrorCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        /** @var Closure $closure */
        $closure = $staticCall->args[0]->value;
        $this->nodesToAddCollector->addNodesAfterNode((array) $closure->stmts, $staticCall);
        $this->nodesToRemoveCollector->addNodeToRemove($staticCall);
        /** @var ClassMethod|null $classMethod */
        $classMethod = $staticCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            return;
        }
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->addBareTag('@doesNotPerformAssertions');
    }
    private function renameAssertMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        foreach (self::ASSERT_METHODS_REMAP as $oldMethod => $newMethod) {
            if (!$this->nodeNameResolver->isName($staticCall->name, $oldMethod)) {
                continue;
            }
            $staticCall->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($newMethod);
        }
    }
    private function sholdBeStaticCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : bool
    {
        return !(bool) $staticCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
    }
    private function refactorExpectException(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : string
    {
        $method = 'expectExceptionMessage';
        if ($this->sholdBeStaticCall($staticCall)) {
            $expectExceptionMessage = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::SELF), $method);
        } else {
            $expectExceptionMessage = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable(self::THIS), $method);
        }
        $expectExceptionMessage->args[] = $staticCall->args[2];
        $this->nodesToAddCollector->addNodeAfterNode($expectExceptionMessage, $staticCall);
        return $method;
    }
    private function refactorExpectExceptionCode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        $method = 'expectExceptionCode';
        if ($this->sholdBeStaticCall($staticCall)) {
            $expectExceptionCode = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::SELF), $method);
        } else {
            $expectExceptionCode = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable(self::THIS), $method);
        }
        $expectExceptionCode->args[] = $staticCall->args[3];
        $this->nodesToAddCollector->addNodeAfterNode($expectExceptionCode, $staticCall);
    }
}
