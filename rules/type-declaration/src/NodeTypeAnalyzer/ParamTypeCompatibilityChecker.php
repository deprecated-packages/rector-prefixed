<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\NodeTypeAnalyzer;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\Type;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PHPStan\TypeComparator;
use Rector\StaticTypeMapper\StaticTypeMapper;
final class ParamTypeCompatibilityChecker
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->typeComparator = $typeComparator;
    }
    public function isCompatibleWithParamStrictTyped(\PhpParser\Node\Arg $arg, \PHPStan\Type\Type $argValueType) : bool
    {
        // cannot verify, assume good
        if (!$arg->value instanceof \PhpParser\Node\Expr\Variable) {
            return \true;
        }
        $argumentVariableName = $this->nodeNameResolver->getName($arg->value);
        $classMethod = $arg->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        foreach ($classMethod->getParams() as $param) {
            if (!$this->nodeNameResolver->isName($param->var, $argumentVariableName)) {
                continue;
            }
            if ($param->type === null) {
                // docblock defined, remove it
                return \false;
            }
            $paramType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
            return $this->typeComparator->areTypesEqual($paramType, $argValueType);
        }
        return \true;
    }
}
