<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\RemovingStatic\NodeAnalyzer\StaticCallPresenceAnalyzer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\SingleStaticServiceToDynamicRectorTest
 */
final class SingleStaticServiceToDynamicRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CLASS_TYPES = 'class_types';
    /**
     * @var string
     */
    private const THIS = 'this';
    /**
     * @var string[]
     */
    private $classTypes = [];
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var StaticCallPresenceAnalyzer
     */
    private $staticCallPresenceAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScopere8e811afab72\Rector\RemovingStatic\NodeAnalyzer\StaticCallPresenceAnalyzer $staticCallPresenceAnalyzer)
    {
        $this->propertyNaming = $propertyNaming;
        $this->staticCallPresenceAnalyzer = $staticCallPresenceAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change full static service, to dynamic one', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class AnotherClass
{
    public function run()
    {
        SomeClass::someStatic();
    }
}

class SomeClass
{
    public static function run()
    {
        self::someStatic();
    }

    private static function someStatic()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class AnotherClass
{
    /**
     * @var SomeClass
     */
    private $someClass;

    public fuction __construct(SomeClass $someClass)
    {
        $this->someClass = $someClass;
    }

    public function run()
    {
        SomeClass::someStatic();
    }
}

class SomeClass
{
    public function run()
    {
        $this->someStatic();
    }

    private function someStatic()
    {
    }
}
CODE_SAMPLE
, [self::CLASS_TYPES => ['SomeClass']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch::class];
    }
    /**
     * @param Class_|ClassMethod|StaticCall|Property|StaticPropertyFetch $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return $this->refactorClassMethod($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return $this->refactorStaticCall($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return $this->refactorClass($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property) {
            return $this->refactorProperty($node);
        }
        return $this->refactorStaticPropertyFetch($node);
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $this->classTypes = $configuration[self::CLASS_TYPES] ?? [];
    }
    private function refactorClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        foreach ($this->classTypes as $classType) {
            if (!$this->isInClassNamed($classMethod, $classType)) {
                continue;
            }
            $this->makeNonStatic($classMethod);
            return $classMethod;
        }
        return null;
    }
    private function refactorStaticCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall $staticCall) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        foreach ($this->classTypes as $classType) {
            if (!$this->isObjectType($staticCall->class, $classType)) {
                continue;
            }
            // is the same class or external call?
            $className = $this->getName($staticCall->class);
            if ($className === 'self') {
                return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(self::THIS), $staticCall->name, $staticCall->args);
            }
            $propertyName = $this->propertyNaming->fqnToVariableName($classType);
            $currentMethodName = $staticCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if ($currentMethodName === \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
                $propertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($propertyName);
            } else {
                $propertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(self::THIS), $propertyName);
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($propertyFetch, $staticCall->name, $staticCall->args);
        }
        return null;
    }
    private function refactorClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        foreach ($this->classTypes as $classType) {
            // do not any dependencies to class itself
            if ($this->isObjectType($class, $classType)) {
                continue;
            }
            $this->completeDependencyToConstructorOnly($class, $classType);
            if ($this->staticCallPresenceAnalyzer->hasClassAnyMethodWithStaticCallOnType($class, $classType)) {
                $singleObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($classType);
                $propertyExpectedName = $this->propertyNaming->fqnToVariableName($classType);
                $this->addConstructorDependencyToClass($class, $singleObjectType, $propertyExpectedName);
                return $class;
            }
        }
        return null;
    }
    private function refactorProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property
    {
        if (!$property->isStatic()) {
            return null;
        }
        foreach ($this->classTypes as $classType) {
            if (!$this->isInClassNamed($property, $classType)) {
                continue;
            }
            $this->makeNonStatic($property);
            return $property;
        }
        return null;
    }
    private function refactorStaticPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch $staticPropertyFetch) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch
    {
        // A. remove local fetch
        foreach ($this->classTypes as $classType) {
            if (!$this->isInClassNamed($staticPropertyFetch, $classType)) {
                continue;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(self::THIS), $staticPropertyFetch->name);
        }
        // B. external property fetch
        // A. remove local fetch
        foreach ($this->classTypes as $classType) {
            if (!$this->isObjectType($staticPropertyFetch->class, $classType)) {
                continue;
            }
            $propertyName = $this->propertyNaming->fqnToVariableName($classType);
            /** @var Class_ $class */
            $class = $staticPropertyFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            $this->addConstructorDependencyToClass($class, new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($classType), $propertyName);
            $objectPropertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable(self::THIS), $propertyName);
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch($objectPropertyFetch, $staticPropertyFetch->name);
        }
        return null;
    }
    private function completeDependencyToConstructorOnly(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, string $classType) : void
    {
        $constructClassMethod = $class->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return;
        }
        $hasStaticCall = $this->staticCallPresenceAnalyzer->hasMethodStaticCallOnType($constructClassMethod, $classType);
        if (!$hasStaticCall) {
            return;
        }
        $propertyExpectedName = $this->propertyNaming->fqnToVariableName(new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($classType));
        if ($this->isTypeAlreadyInParamMethod($constructClassMethod, $classType)) {
            return;
        }
        $constructClassMethod->params[] = new \_PhpScopere8e811afab72\PhpParser\Node\Param(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($propertyExpectedName), null, new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($classType));
    }
    private function isTypeAlreadyInParamMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $classType) : bool
    {
        foreach ($classMethod->getParams() as $param) {
            if ($param->type === null) {
                continue;
            }
            if ($this->isName($param->type, $classType)) {
                return \true;
            }
        }
        return \false;
    }
}
