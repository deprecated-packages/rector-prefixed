<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\StaticTypeToSetterInjectionRectorTest
 */
final class StaticTypeToSetterInjectionRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        // custom made only for Elasticr
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes types to setter injection', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
<?php

namespace _PhpScoperb75b35f52b74;

final class CheckoutEntityFactory
{
    public function run()
    {
        return \_PhpScoperb75b35f52b74\SomeStaticClass::go();
    }
}
\class_alias('_PhpScoperb75b35f52b74\\CheckoutEntityFactory', 'CheckoutEntityFactory', \false);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
<?php

namespace _PhpScoperb75b35f52b74;

final class CheckoutEntityFactory
{
    /**
     * @var SomeStaticClass
     */
    private $someStaticClass;
    public function setSomeStaticClass(\_PhpScoperb75b35f52b74\SomeStaticClass $someStaticClass)
    {
        $this->someStaticClass = $someStaticClass;
    }
    public function run()
    {
        return $this->someStaticClass->go();
    }
}
\class_alias('_PhpScoperb75b35f52b74\\CheckoutEntityFactory', 'CheckoutEntityFactory', \false);
CODE_SAMPLE
, [self::STATIC_TYPES => ['SomeStaticClass']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall|Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return $this->processClass($node);
        }
        foreach ($this->staticTypes as $staticType) {
            $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($staticType);
            if (!$this->isObjectType($node->class, $objectType)) {
                continue;
            }
            $variableName = $this->propertyNaming->fqnToVariableName($objectType);
            $propertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $variableName);
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($propertyFetch, $node->name, $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->staticTypes = $configuration[self::STATIC_TYPES] ?? [];
    }
    private function processClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
    {
        foreach ($this->staticTypes as $implements => $staticType) {
            $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($staticType);
            $containsEntityFactoryStaticCall = (bool) $this->betterNodeFinder->findFirst($class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($objectType) : bool {
                return $this->isEntityFactoryStaticCall($node, $objectType);
            });
            if (!$containsEntityFactoryStaticCall) {
                continue;
            }
            if (\is_string($implements)) {
                $class->implements[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($implements);
            }
            $variableName = $this->propertyNaming->fqnToVariableName($objectType);
            $paramBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder($variableName);
            $paramBuilder->setType(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($staticType));
            $param = $paramBuilder->getNode();
            $assign = $this->nodeFactory->createPropertyAssignment($variableName);
            $setEntityFactoryMethod = $this->createSetEntityFactoryClassMethod($variableName, $param, $assign);
            $entityFactoryProperty = $this->nodeFactory->createPrivateProperty($variableName);
            /** @var PhpDocInfo $phpDocInfo */
            $phpDocInfo = $entityFactoryProperty->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            $phpDocInfo->changeVarType($objectType);
            $class->stmts = \array_merge([$entityFactoryProperty, $setEntityFactoryMethod], $class->stmts);
            break;
        }
        return $class;
    }
    private function isEntityFactoryStaticCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        return $this->isObjectType($node->class, $objectType);
    }
    private function createSetEntityFactoryClassMethod(string $variableName, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $setMethodName = 'set' . \ucfirst($variableName);
        $setEntityFactoryMethodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder($setMethodName);
        $setEntityFactoryMethodBuilder->makePublic();
        $setEntityFactoryMethodBuilder->addParam($param);
        $setEntityFactoryMethodBuilder->setReturnType('void');
        $setEntityFactoryMethodBuilder->addStmt($assign);
        return $setEntityFactoryMethodBuilder->getNode();
    }
}
