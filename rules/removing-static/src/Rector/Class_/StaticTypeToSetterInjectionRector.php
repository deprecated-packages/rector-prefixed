<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\RemovingStatic\Rector\Class_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\StaticTypeToSetterInjectionRectorTest
 */
final class StaticTypeToSetterInjectionRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        // custom made only for Elasticr
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes types to setter injection', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
<?php

namespace _PhpScoper2a4e7ab1ecbc;

final class CheckoutEntityFactory
{
    public function run()
    {
        return \_PhpScoper2a4e7ab1ecbc\SomeStaticClass::go();
    }
}
\class_alias('_PhpScoper2a4e7ab1ecbc\\CheckoutEntityFactory', 'CheckoutEntityFactory', \false);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
<?php

namespace _PhpScoper2a4e7ab1ecbc;

final class CheckoutEntityFactory
{
    /**
     * @var SomeStaticClass
     */
    private $someStaticClass;
    public function setSomeStaticClass(\_PhpScoper2a4e7ab1ecbc\SomeStaticClass $someStaticClass)
    {
        $this->someStaticClass = $someStaticClass;
    }
    public function run()
    {
        return $this->someStaticClass->go();
    }
}
\class_alias('_PhpScoper2a4e7ab1ecbc\\CheckoutEntityFactory', 'CheckoutEntityFactory', \false);
CODE_SAMPLE
, [self::STATIC_TYPES => ['SomeStaticClass']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall|Class_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_) {
            return $this->processClass($node);
        }
        foreach ($this->staticTypes as $staticType) {
            $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($staticType);
            if (!$this->isObjectType($node->class, $objectType)) {
                continue;
            }
            $variableName = $this->propertyNaming->fqnToVariableName($objectType);
            $propertyFetch = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('this'), $variableName);
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($propertyFetch, $node->name, $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->staticTypes = $configuration[self::STATIC_TYPES] ?? [];
    }
    private function processClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_
    {
        foreach ($this->staticTypes as $implements => $staticType) {
            $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($staticType);
            $containsEntityFactoryStaticCall = (bool) $this->betterNodeFinder->findFirst($class->stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($objectType) : bool {
                return $this->isEntityFactoryStaticCall($node, $objectType);
            });
            if (!$containsEntityFactoryStaticCall) {
                continue;
            }
            if (\is_string($implements)) {
                $class->implements[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($implements);
            }
            $variableName = $this->propertyNaming->fqnToVariableName($objectType);
            $paramBuilder = new \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ParamBuilder($variableName);
            $paramBuilder->setType(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($staticType));
            $param = $paramBuilder->getNode();
            $assign = $this->nodeFactory->createPropertyAssignment($variableName);
            $setEntityFactoryMethod = $this->createSetEntityFactoryClassMethod($variableName, $param, $assign);
            $entityFactoryProperty = $this->nodeFactory->createPrivateProperty($variableName);
            /** @var PhpDocInfo $phpDocInfo */
            $phpDocInfo = $entityFactoryProperty->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            $phpDocInfo->changeVarType($objectType);
            $class->stmts = \array_merge([$entityFactoryProperty, $setEntityFactoryMethod], $class->stmts);
            break;
        }
        return $class;
    }
    private function isEntityFactoryStaticCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType $objectType) : bool
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        return $this->isObjectType($node->class, $objectType);
    }
    private function createSetEntityFactoryClassMethod(string $variableName, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod
    {
        $setMethodName = 'set' . \ucfirst($variableName);
        $setEntityFactoryMethodBuilder = new \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\MethodBuilder($setMethodName);
        $setEntityFactoryMethodBuilder->makePublic();
        $setEntityFactoryMethodBuilder->addParam($param);
        $setEntityFactoryMethodBuilder->setReturnType('void');
        $setEntityFactoryMethodBuilder->addStmt($assign);
        return $setEntityFactoryMethodBuilder->getNode();
    }
}
