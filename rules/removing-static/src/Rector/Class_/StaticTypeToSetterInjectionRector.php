<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\StaticTypeToSetterInjectionRectorTest
 */
final class StaticTypeToSetterInjectionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const STATIC_TYPES = 'static_types';
    /**
     * @var string[]
     */
    private $staticTypes = [];
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        // custom made only for Elasticr
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes types to setter injection', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
<?php

namespace _PhpScopere8e811afab72;

final class CheckoutEntityFactory
{
    public function run()
    {
        return \_PhpScopere8e811afab72\SomeStaticClass::go();
    }
}
\class_alias('_PhpScopere8e811afab72\\CheckoutEntityFactory', 'CheckoutEntityFactory', \false);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
<?php

namespace _PhpScopere8e811afab72;

final class CheckoutEntityFactory
{
    /**
     * @var SomeStaticClass
     */
    private $someStaticClass;
    public function setSomeStaticClass(\_PhpScopere8e811afab72\SomeStaticClass $someStaticClass)
    {
        $this->someStaticClass = $someStaticClass;
    }
    public function run()
    {
        return $this->someStaticClass->go();
    }
}
\class_alias('_PhpScopere8e811afab72\\CheckoutEntityFactory', 'CheckoutEntityFactory', \false);
CODE_SAMPLE
, [self::STATIC_TYPES => ['SomeStaticClass']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall|Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return $this->processClass($node);
        }
        foreach ($this->staticTypes as $staticType) {
            $objectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($staticType);
            if (!$this->isObjectType($node->class, $objectType)) {
                continue;
            }
            $variableName = $this->propertyNaming->fqnToVariableName($objectType);
            $propertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $variableName);
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($propertyFetch, $node->name, $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->staticTypes = $configuration[self::STATIC_TYPES] ?? [];
    }
    private function processClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        foreach ($this->staticTypes as $implements => $staticType) {
            $objectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($staticType);
            $containsEntityFactoryStaticCall = (bool) $this->betterNodeFinder->findFirst($class->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($objectType) : bool {
                return $this->isEntityFactoryStaticCall($node, $objectType);
            });
            if (!$containsEntityFactoryStaticCall) {
                continue;
            }
            if (\is_string($implements)) {
                $class->implements[] = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($implements);
            }
            $variableName = $this->propertyNaming->fqnToVariableName($objectType);
            $paramBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ParamBuilder($variableName);
            $paramBuilder->setType(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($staticType));
            $param = $paramBuilder->getNode();
            $assign = $this->nodeFactory->createPropertyAssignment($variableName);
            $setEntityFactoryMethod = $this->createSetEntityFactoryClassMethod($variableName, $param, $assign);
            $entityFactoryProperty = $this->nodeFactory->createPrivateProperty($variableName);
            /** @var PhpDocInfo $phpDocInfo */
            $phpDocInfo = $entityFactoryProperty->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            $phpDocInfo->changeVarType($objectType);
            $class->stmts = \array_merge([$entityFactoryProperty, $setEntityFactoryMethod], $class->stmts);
            break;
        }
        return $class;
    }
    private function isEntityFactoryStaticCall(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Type\ObjectType $objectType) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        return $this->isObjectType($node->class, $objectType);
    }
    private function createSetEntityFactoryClassMethod(string $variableName, \_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $setMethodName = 'set' . \ucfirst($variableName);
        $setEntityFactoryMethodBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder($setMethodName);
        $setEntityFactoryMethodBuilder->makePublic();
        $setEntityFactoryMethodBuilder->addParam($param);
        $setEntityFactoryMethodBuilder->setReturnType('void');
        $setEntityFactoryMethodBuilder->addStmt($assign);
        return $setEntityFactoryMethodBuilder->getNode();
    }
}
