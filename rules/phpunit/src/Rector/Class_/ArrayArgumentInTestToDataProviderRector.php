<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\NodeFactory\DataProviderClassMethodFactory;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\DataProviderClassMethodRecipe;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\ParamAndArg;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @see \Rector\PHPUnit\Tests\Rector\Class_\ArrayArgumentInTestToDataProviderRector\ArrayArgumentInTestToDataProviderRectorTest
 *
 * @see why → https://blog.martinhujer.cz/how-to-use-data-providers-in-phpunit/
 */
final class ArrayArgumentInTestToDataProviderRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const ARRAY_ARGUMENTS_TO_DATA_PROVIDERS = 'array_arguments_to_data_providers';
    /**
     * @var ArrayArgumentToDataProvider[]
     */
    private $arrayArgumentsToDataProviders = [];
    /**
     * @var DataProviderClassMethodRecipe[]
     */
    private $dataProviderClassMethodRecipes = [];
    /**
     * @var DataProviderClassMethodFactory
     */
    private $dataProviderClassMethodFactory;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PHPUnit\NodeFactory\DataProviderClassMethodFactory $dataProviderClassMethodFactory, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->dataProviderClassMethodFactory = $dataProviderClassMethodFactory;
        $this->typeFactory = $typeFactory;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move array argument from tests into data provider [configurable]', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

class SomeServiceTest extends TestCase
{
    public function test()
    {
        $this->doTestMultiple([1, 2, 3]);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

class SomeServiceTest extends TestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(int $number)
    {
        $this->doTestSingle($number);
    }

    public function provideData(): \Iterator
    {
        yield [1];
        yield [2];
        yield [3];
    }
}
CODE_SAMPLE
, [self::ARRAY_ARGUMENTS_TO_DATA_PROVIDERS => [new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider('_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase', 'doTestMultiple', 'doTestSingle', 'number')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        $this->dataProviderClassMethodRecipes = [];
        $this->traverseNodesWithCallable($node->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            foreach ($this->arrayArgumentsToDataProviders as $arrayArgumentsToDataProvider) {
                $this->refactorMethodCallWithConfiguration($node, $arrayArgumentsToDataProvider);
            }
            return null;
        });
        if ($this->dataProviderClassMethodRecipes === []) {
            return null;
        }
        $dataProviderClassMethods = $this->createDataProviderClassMethodsFromRecipes();
        $node->stmts = \array_merge($node->stmts, $dataProviderClassMethods);
        return $node;
    }
    public function configure(array $arrayArgumentsToDataProviders) : void
    {
        $arrayArgumentsToDataProviders = $arrayArgumentsToDataProviders[self::ARRAY_ARGUMENTS_TO_DATA_PROVIDERS] ?? [];
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsInstanceOf($arrayArgumentsToDataProviders, \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider::class);
        $this->arrayArgumentsToDataProviders = $arrayArgumentsToDataProviders;
    }
    private function refactorMethodCallWithConfiguration(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider $arrayArgumentToDataProvider) : void
    {
        if (!$this->isMethodCallMatch($methodCall, $arrayArgumentToDataProvider)) {
            return;
        }
        if (\count((array) $methodCall->args) !== 1) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        // resolve value types
        $firstArgumentValue = $methodCall->args[0]->value;
        if (!$firstArgumentValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
            // nothing we can do
            return;
        }
        // rename method to new one handling non-array input
        $methodCall->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($arrayArgumentToDataProvider->getNewMethod());
        $dataProviderMethodName = $this->createDataProviderMethodName($methodCall);
        $this->dataProviderClassMethodRecipes[] = new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\DataProviderClassMethodRecipe($dataProviderMethodName, $methodCall->args);
        $methodCall->args = [];
        $paramAndArgs = $this->collectParamAndArgsFromArray($firstArgumentValue, $arrayArgumentToDataProvider->getVariableName());
        foreach ($paramAndArgs as $paramAndArg) {
            $methodCall->args[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($paramAndArg->getVariable());
        }
        /** @var ClassMethod $classMethod */
        $classMethod = $methodCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        $this->refactorTestClassMethodParams($classMethod, $paramAndArgs);
        // add data provider annotation
        $dataProviderTagNode = $this->createDataProviderTagNode($dataProviderMethodName);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->addPhpDocTagNode($dataProviderTagNode);
    }
    /**
     * @return ClassMethod[]
     */
    private function createDataProviderClassMethodsFromRecipes() : array
    {
        $dataProviderClassMethods = [];
        foreach ($this->dataProviderClassMethodRecipes as $dataProviderClassMethodRecipe) {
            $dataProviderClassMethods[] = $this->dataProviderClassMethodFactory->createFromRecipe($dataProviderClassMethodRecipe);
        }
        return $dataProviderClassMethods;
    }
    private function isMethodCallMatch(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider $arrayArgumentToDataProvider) : bool
    {
        if (!$this->isObjectType($methodCall->var, $arrayArgumentToDataProvider->getClass())) {
            return \false;
        }
        return $this->isName($methodCall->name, $arrayArgumentToDataProvider->getOldMethod());
    }
    private function createDataProviderMethodName(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        /** @var string $methodName */
        $methodName = $methodCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        return 'provideDataFor' . \ucfirst($methodName);
    }
    /**
     * @return ParamAndArg[]
     */
    private function collectParamAndArgsFromArray(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array, string $variableName) : array
    {
        $isNestedArray = $this->isNestedArray($array);
        if ($isNestedArray) {
            return $this->collectParamAndArgsFromNestedArray($array, $variableName);
        }
        $itemsStaticType = $this->resolveItemStaticType($array, $isNestedArray);
        return $this->collectParamAndArgsFromNonNestedArray($array, $variableName, $itemsStaticType);
    }
    /**
     * @param ParamAndArg[] $paramAndArgs
     */
    private function refactorTestClassMethodParams(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, array $paramAndArgs) : void
    {
        $classMethod->params = $this->createParams($paramAndArgs);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        foreach ($paramAndArgs as $paramAndArg) {
            $staticType = $paramAndArg->getType();
            if (!$staticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
                continue;
            }
            /** @var string $paramName */
            $paramName = $this->getName($paramAndArg->getVariable());
            /** @var TypeNode $staticTypeNode */
            $staticTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($staticType);
            $paramTagValueNode = $this->createParamTagNode($paramName, $staticTypeNode);
            $phpDocInfo->addTagValueNode($paramTagValueNode);
        }
    }
    private function createDataProviderTagNode(string $dataProviderMethodName) : \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode('@dataProvider', new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode($dataProviderMethodName . '()'));
    }
    private function isNestedArray(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array) : bool
    {
        foreach ($array->items as $arrayItem) {
            if (!$arrayItem instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            if ($arrayItem->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return ParamAndArg[]
     */
    private function collectParamAndArgsFromNestedArray(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array, string $variableName) : array
    {
        $paramAndArgs = [];
        $i = 1;
        foreach ($array->items as $arrayItem) {
            if (!$arrayItem instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            $nestedArray = $arrayItem->value;
            if (!$nestedArray instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
                continue;
            }
            foreach ($nestedArray->items as $nestedArrayItem) {
                if (!$nestedArrayItem instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                    continue;
                }
                $variable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($variableName . ($i === 1 ? '' : $i));
                $itemsStaticType = $this->getStaticType($nestedArrayItem->value);
                $paramAndArgs[] = new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\ParamAndArg($variable, $itemsStaticType);
                ++$i;
            }
        }
        return $paramAndArgs;
    }
    private function resolveItemStaticType(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array, bool $isNestedArray) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $staticTypes = [];
        if (!$isNestedArray) {
            foreach ($array->items as $arrayItem) {
                if (!$arrayItem instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                    continue;
                }
                $staticTypes[] = $this->getStaticType($arrayItem->value);
            }
        }
        return $this->typeFactory->createMixedPassedOrUnionType($staticTypes);
    }
    /**
     * @return ParamAndArg[]
     */
    private function collectParamAndArgsFromNonNestedArray(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array, string $variableName, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $itemsStaticType) : array
    {
        $i = 1;
        $paramAndArgs = [];
        foreach ($array->items as $arrayItem) {
            if (!$arrayItem instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            $variable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($variableName . ($i === 1 ? '' : $i));
            $paramAndArgs[] = new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\ParamAndArg($variable, $itemsStaticType);
            ++$i;
            if (!$arrayItem->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
                break;
            }
        }
        return $paramAndArgs;
    }
    /**
     * @param ParamAndArg[] $paramAndArgs
     * @return Param[]
     */
    private function createParams(array $paramAndArgs) : array
    {
        $params = [];
        foreach ($paramAndArgs as $paramAndArg) {
            $param = new \_PhpScoper0a6b37af0871\PhpParser\Node\Param($paramAndArg->getVariable());
            $this->setTypeIfNotNull($paramAndArg, $param);
            $params[] = $param;
        }
        return $params;
    }
    private function createParamTagNode(string $name, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode
    {
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode($typeNode, \false, '$' . $name, '', \false);
    }
    private function setTypeIfNotNull(\_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\ParamAndArg $paramAndArg, \_PhpScoper0a6b37af0871\PhpParser\Node\Param $param) : void
    {
        $staticType = $paramAndArg->getType();
        if ($staticType === null) {
            return;
        }
        if ($staticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            return;
        }
        $phpNodeType = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($staticType);
        if ($phpNodeType === null) {
            return;
        }
        $param->type = $phpNodeType;
    }
}
