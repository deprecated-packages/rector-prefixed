<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadDocBlock;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\TypeComparator;
final class DeadParamTagValueNodeAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->typeComparator = $typeComparator;
    }
    public function isDead(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode $paramTagValueNode, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $param = $this->matchParamByName($paramTagValueNode->parameterName, $classMethod);
        if ($param === null) {
            return \false;
        }
        if ($param->type === null) {
            return \false;
        }
        if (!$this->typeComparator->arePhpParserAndPhpStanPhpDocTypesEqual($param->type, $paramTagValueNode->type, $classMethod)) {
            return \false;
        }
        return $paramTagValueNode->description === '';
    }
    private function matchParamByName(string $desiredParamName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Param
    {
        foreach ((array) $classMethod->params as $param) {
            $paramName = $this->nodeNameResolver->getName($param);
            if ('$' . $paramName !== $desiredParamName) {
                continue;
            }
            return $param;
        }
        return null;
    }
}
