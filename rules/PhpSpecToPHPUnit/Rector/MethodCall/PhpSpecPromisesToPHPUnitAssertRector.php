<?php

declare (strict_types=1);
namespace Rector\PhpSpecToPHPUnit\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Clone_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PhpSpecToPHPUnit\MatchersManipulator;
use Rector\PhpSpecToPHPUnit\Naming\PhpSpecRenaming;
use Rector\PhpSpecToPHPUnit\NodeFactory\AssertMethodCallFactory;
use Rector\PhpSpecToPHPUnit\NodeFactory\BeConstructedWithAssignFactory;
use Rector\PhpSpecToPHPUnit\NodeFactory\DuringMethodCallFactory;
use Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector;
/**
 * @see \Rector\Tests\PhpSpecToPHPUnit\Rector\Variable\PhpSpecToPHPUnitRector\PhpSpecToPHPUnitRectorTest
 */
final class PhpSpecPromisesToPHPUnitAssertRector extends \Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector
{
    /**
     * @see https://github.com/phpspec/phpspec/blob/master/src/PhpSpec/Wrapper/Subject.php
     * ↓
     * @see https://phpunit.readthedocs.io/en/8.0/assertions.html
     * @var array<string, string[]>
     */
    private const NEW_METHOD_TO_OLD_METHODS = [
        'assertInstanceOf' => ['shouldBeAnInstanceOf', 'shouldHaveType', 'shouldReturnAnInstanceOf'],
        'assertSame' => ['shouldBe', 'shouldReturn'],
        'assertNotSame' => ['shouldNotBe', 'shouldNotReturn'],
        'assertCount' => ['shouldHaveCount'],
        'assertEquals' => ['shouldBeEqualTo'],
        'assertNotEquals' => ['shouldNotBeEqualTo'],
        'assertContains' => ['shouldContain'],
        'assertNotContains' => ['shouldNotContain'],
        // types
        'assertIsIterable' => ['shouldBeArray'],
        'assertIsNotIterable' => ['shouldNotBeArray'],
        'assertIsString' => ['shouldBeString'],
        'assertIsNotString' => ['shouldNotBeString'],
        'assertIsBool' => ['shouldBeBool', 'shouldBeBoolean'],
        'assertIsNotBool' => ['shouldNotBeBool', 'shouldNotBeBoolean'],
        'assertIsCallable' => ['shouldBeCallable'],
        'assertIsNotCallable' => ['shouldNotBeCallable'],
        'assertIsFloat' => ['shouldBeDouble', 'shouldBeFloat'],
        'assertIsNotFloat' => ['shouldNotBeDouble', 'shouldNotBeFloat'],
        'assertIsInt' => ['shouldBeInt', 'shouldBeInteger'],
        'assertIsNotInt' => ['shouldNotBeInt', 'shouldNotBeInteger'],
        'assertIsNull' => ['shouldBeNull'],
        'assertIsNotNull' => ['shouldNotBeNull'],
        'assertIsNumeric' => ['shouldBeNumeric'],
        'assertIsNotNumeric' => ['shouldNotBeNumeric'],
        'assertIsObject' => ['shouldBeObject'],
        'assertIsNotObject' => ['shouldNotBeObject'],
        'assertIsResource' => ['shouldBeResource'],
        'assertIsNotResource' => ['shouldNotBeResource'],
        'assertIsScalar' => ['shouldBeScalar'],
        'assertIsNotScalar' => ['shouldNotBeScalar'],
        'assertNan' => ['shouldBeNan'],
        'assertFinite' => ['shouldBeFinite', 'shouldNotBeFinite'],
        'assertInfinite' => ['shouldBeInfinite', 'shouldNotBeInfinite'],
    ];
    /**
     * @var string
     */
    private const THIS = 'this';
    /**
     * @var string
     */
    private $testedClass;
    /**
     * @var bool
     */
    private $isPrepared = \false;
    /**
     * @var string[]
     */
    private $matchersKeys = [];
    /**
     * @var PropertyFetch
     */
    private $testedObjectPropertyFetch;
    /**
     * @var PhpSpecRenaming
     */
    private $phpSpecRenaming;
    /**
     * @var MatchersManipulator
     */
    private $matchersManipulator;
    /**
     * @var AssertMethodCallFactory
     */
    private $assertMethodCallFactory;
    /**
     * @var BeConstructedWithAssignFactory
     */
    private $beConstructedWithAssignFactory;
    /**
     * @var DuringMethodCallFactory
     */
    private $duringMethodCallFactory;
    public function __construct(\Rector\PhpSpecToPHPUnit\MatchersManipulator $matchersManipulator, \Rector\PhpSpecToPHPUnit\Naming\PhpSpecRenaming $phpSpecRenaming, \Rector\PhpSpecToPHPUnit\NodeFactory\AssertMethodCallFactory $assertMethodCallFactory, \Rector\PhpSpecToPHPUnit\NodeFactory\BeConstructedWithAssignFactory $beConstructedWithAssignFactory, \Rector\PhpSpecToPHPUnit\NodeFactory\DuringMethodCallFactory $duringMethodCallFactory)
    {
        $this->phpSpecRenaming = $phpSpecRenaming;
        $this->matchersManipulator = $matchersManipulator;
        $this->assertMethodCallFactory = $assertMethodCallFactory;
        $this->beConstructedWithAssignFactory = $beConstructedWithAssignFactory;
        $this->duringMethodCallFactory = $duringMethodCallFactory;
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        $this->isPrepared = \false;
        $this->matchersKeys = [];
        if (!$this->isInPhpSpecBehavior($node)) {
            return null;
        }
        if ($this->isName($node->name, 'getWrappedObject')) {
            return $node->var;
        }
        if ($this->isName($node->name, 'during')) {
            return $this->duringMethodCallFactory->create($node, $this->testedObjectPropertyFetch);
        }
        if ($this->isName($node->name, 'duringInstantiation')) {
            return $this->processDuringInstantiation($node);
        }
        if ($this->isName($node->name, 'getMatchers')) {
            return null;
        }
        $this->prepareMethodCall($node);
        if ($this->isName($node->name, 'beConstructed*')) {
            return $this->beConstructedWithAssignFactory->create($node, $this->testedClass, $this->testedObjectPropertyFetch);
        }
        $this->processMatchersKeys($node);
        foreach (self::NEW_METHOD_TO_OLD_METHODS as $newMethod => $oldMethods) {
            if (!$this->isNames($node->name, $oldMethods)) {
                continue;
            }
            return $this->assertMethodCallFactory->createAssertMethod($newMethod, $node->var, $node->args[0]->value ?? null, $this->testedObjectPropertyFetch);
        }
        if ($this->shouldSkip($node)) {
            return null;
        }
        if ($this->isName($node->name, 'clone')) {
            return new \PhpParser\Node\Expr\Clone_($this->testedObjectPropertyFetch);
        }
        $methodName = $this->getName($node->name);
        if ($methodName === null) {
            return null;
        }
        /** @var Class_ $classLike */
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        $classMethod = $classLike->getMethod($methodName);
        // it's a method call, skip
        if ($classMethod !== null) {
            return null;
        }
        $node->var = $this->testedObjectPropertyFetch;
        return $node;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    private function processDuringInstantiation($methodCall) : \PhpParser\Node\Expr\MethodCall
    {
        /** @var MethodCall $parentMethodCall */
        $parentMethodCall = $methodCall->var;
        $parentMethodCall->name = new \PhpParser\Node\Identifier('expectException');
        return $parentMethodCall;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    private function prepareMethodCall($methodCall) : void
    {
        if ($this->isPrepared) {
            return;
        }
        /** @var Class_ $classLike */
        $classLike = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        $this->matchersKeys = $this->matchersManipulator->resolveMatcherNamesFromClass($classLike);
        $this->testedClass = $this->phpSpecRenaming->resolveTestedClass($methodCall);
        $this->testedObjectPropertyFetch = $this->createTestedObjectPropertyFetch($classLike);
        $this->isPrepared = \true;
    }
    /**
     * @see https://johannespichler.com/writing-custom-phpspec-matchers/
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    private function processMatchersKeys($methodCall) : void
    {
        foreach ($this->matchersKeys as $matcherKey) {
            if (!$this->isName($methodCall->name, 'should' . \ucfirst($matcherKey))) {
                continue;
            }
            if (!$methodCall->var instanceof \PhpParser\Node\Expr\MethodCall) {
                continue;
            }
            // 1. assign callable to variable
            $thisGetMatchers = $this->nodeFactory->createMethodCall(self::THIS, 'getMatchers');
            $arrayDimFetch = new \PhpParser\Node\Expr\ArrayDimFetch($thisGetMatchers, new \PhpParser\Node\Scalar\String_($matcherKey));
            $matcherCallableVariable = new \PhpParser\Node\Expr\Variable('matcherCallable');
            $assign = new \PhpParser\Node\Expr\Assign($matcherCallableVariable, $arrayDimFetch);
            // 2. call it on result
            $funcCall = new \PhpParser\Node\Expr\FuncCall($matcherCallableVariable);
            $funcCall->args = $methodCall->args;
            $methodCall->name = $methodCall->var->name;
            $methodCall->var = $this->testedObjectPropertyFetch;
            $methodCall->args = [];
            $funcCall->args[] = new \PhpParser\Node\Arg($methodCall);
            $this->addNodesAfterNode([$assign, $funcCall], $methodCall);
            $this->removeNode($methodCall);
            return;
        }
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    private function shouldSkip($methodCall) : bool
    {
        if (!$this->nodeNameResolver->isVariableName($methodCall->var, self::THIS)) {
            return \true;
        }
        // skip "createMock" method
        return $this->isName($methodCall->name, 'createMock');
    }
    /**
     * @param \PhpParser\Node\Stmt\Class_ $class
     */
    private function createTestedObjectPropertyFetch($class) : \PhpParser\Node\Expr\PropertyFetch
    {
        $propertyName = $this->phpSpecRenaming->resolveObjectPropertyName($class);
        return new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable(self::THIS), $propertyName);
    }
}
