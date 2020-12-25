<?php

declare (strict_types=1);
namespace Rector\StrictCodeQuality\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\StrictCodeQuality\Tests\Rector\ClassMethod\ParamTypeToAssertTypeRector\ParamTypeToAssertTypeRectorTest
 */
final class ParamTypeToAssertTypeRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turn @param type to assert type', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
            if (!$paramType instanceof \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType && !$paramType instanceof \PHPStan\Type\UnionType && !$paramType instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
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
    private function getTypes(\PHPStan\Type\Type $type) : array
    {
        return $type instanceof \PHPStan\Type\UnionType ? $type->getTypes() : [$type];
    }
    /**
     * @param Type[] $types
     */
    private function isNotClassTypes(array $types) : bool
    {
        foreach ($types as $type) {
            if (!$type instanceof \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType && !$type instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
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
            if (!$param->type instanceof \PhpParser\Node\Name\FullyQualified || $key !== '$' . $paramVarName) {
                continue;
            }
            foreach ($types as $type) {
                $className = $type instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType ? $type->getFullyQualifiedName() : $type->getClassName();
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
    private function processAddTypeAssert(\PhpParser\Node\Stmt\ClassMethod $classMethod, array $toBeProcessedTypes) : \PhpParser\Node\Stmt\ClassMethod
    {
        $assertStatements = [];
        foreach ($toBeProcessedTypes as $key => $toBeProcessedType) {
            $types = [];
            foreach ($toBeProcessedType as $keyType => $type) {
                $toBeProcessedType[$keyType] = \sprintf('%s::class', $type);
                $types[] = new \PhpParser\Node\Expr\ArrayItem(new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name($toBeProcessedType[$keyType])));
            }
            if (\count($types) > 1) {
                $args = [new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\Variable($key)), new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\Array_($types))];
                $staticCall = $this->createStaticCall('_PhpScoper50d83356d739\\Webmozart\\Assert\\Assert', 'isAnyOf', $args);
                $assertStatements[] = new \PhpParser\Node\Stmt\Expression($staticCall);
            } else {
                $args = [new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\Variable($key)), new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name($toBeProcessedType[0])))];
                $staticCall = $this->createStaticCall('_PhpScoper50d83356d739\\Webmozart\\Assert\\Assert', 'isAOf', $args);
                $assertStatements[] = new \PhpParser\Node\Stmt\Expression($staticCall);
            }
        }
        return $this->addStatements($classMethod, $assertStatements);
    }
    /**
     * @param array<int, Expression> $assertStatements
     */
    private function addStatements(\PhpParser\Node\Stmt\ClassMethod $classMethod, array $assertStatements) : \PhpParser\Node\Stmt\ClassMethod
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
