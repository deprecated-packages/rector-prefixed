<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\StrictCodeQuality\Rector\ClassMethod;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\StrictCodeQuality\Tests\Rector\ClassMethod\ParamTypeToAssertTypeRector\ParamTypeToAssertTypeRectorTest
 */
final class ParamTypeToAssertTypeRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turn @param type to assert type', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param \A|\B $arg
     */
    public function run($arg)
    {

    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param \A|\B $arg
     */
    public function run($arg)
    {
        \Webmozart\Assert\Assert::isAnyOf($arg, [\A::class, \B::class]);
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        /** @var Type[] $paramTypes */
        $paramTypes = $phpDocInfo->getParamTypesByName();
        /** @var Param[] $params */
        $params = $node->getParams();
        if ($paramTypes === []) {
            return null;
        }
        if ($params === []) {
            return null;
        }
        $toBeProcessedTypes = [];
        foreach ($paramTypes as $key => $paramType) {
            if (!$paramType instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType && !$paramType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType && !$paramType instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
                continue;
            }
            $types = $this->getTypes($paramType);
            if ($this->isNotClassTypes($types)) {
                continue;
            }
            $toBeProcessedTypes = $this->getToBeProcessedTypes($params, $key, $types, $toBeProcessedTypes);
        }
        return $this->processAddTypeAssert($node, $toBeProcessedTypes);
    }
    /**
     * @return Type[]
     */
    private function getTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : array
    {
        return $type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType ? $type->getTypes() : [$type];
    }
    /**
     * @param Type[] $types
     */
    private function isNotClassTypes(array $types) : bool
    {
        foreach ($types as $type) {
            if (!$type instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType && !$type instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param Param[] $params
     * @param Type[] $types
     * @param array<string, array<int, string>> $toBeProcessedTypes
     * @return array<string, array<int, string>>
     */
    private function getToBeProcessedTypes(array $params, string $key, array $types, array $toBeProcessedTypes) : array
    {
        foreach ($params as $param) {
            $paramVarName = $this->getName($param->var);
            if (!$param->type instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified || $key !== '$' . $paramVarName) {
                continue;
            }
            foreach ($types as $type) {
                $className = $type instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType ? $type->getFullyQualifiedName() : $type->getClassName();
                // @todo refactor to types
                if (!\is_a($className, $param->type->toString(), \true) || $className === $param->type->toString()) {
                    continue 2;
                }
                $toBeProcessedTypes[$paramVarName][] = '\\' . $className;
            }
        }
        return $toBeProcessedTypes;
    }
    /**
     * @param array<string, array<int, string>> $toBeProcessedTypes
     */
    private function processAddTypeAssert(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod, array $toBeProcessedTypes) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod
    {
        $assertStatements = [];
        foreach ($toBeProcessedTypes as $key => $toBeProcessedType) {
            $types = [];
            foreach ($toBeProcessedType as $keyType => $type) {
                $toBeProcessedType[$keyType] = \sprintf('%s::class', $type);
                $types[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($toBeProcessedType[$keyType])));
            }
            if (\count($types) > 1) {
                $args = [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable($key)), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_($types))];
                $staticCall = $this->createStaticCall('_PhpScoper2a4e7ab1ecbc\\Webmozart\\Assert\\Assert', 'isAnyOf', $args);
                $assertStatements[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($staticCall);
            } else {
                $args = [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable($key)), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($toBeProcessedType[0])))];
                $staticCall = $this->createStaticCall('_PhpScoper2a4e7ab1ecbc\\Webmozart\\Assert\\Assert', 'isAOf', $args);
                $assertStatements[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($staticCall);
            }
        }
        return $this->addStatements($classMethod, $assertStatements);
    }
    /**
     * @param array<int, Expression> $assertStatements
     */
    private function addStatements(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod, array $assertStatements) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod
    {
        if (!isset($classMethod->stmts[0])) {
            foreach ($assertStatements as $assertStatement) {
                $classMethod->stmts[] = $assertStatement;
            }
        } else {
            foreach ($assertStatements as $assertStatement) {
                $this->addNodeBeforeNode($assertStatement, $classMethod->stmts[0]);
            }
        }
        return $classMethod;
    }
}
