<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\NodeAnalyzer;

use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Rector\VendorLocker\NodeVendorLocker\ClassMethodParamVendorLockResolver;
final class ClassMethodParamTypeCompleter
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var ClassMethodParamVendorLockResolver
     */
    private $classMethodParamVendorLockResolver;
    public function __construct(\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\VendorLocker\NodeVendorLocker\ClassMethodParamVendorLockResolver $classMethodParamVendorLockResolver)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->classMethodParamVendorLockResolver = $classMethodParamVendorLockResolver;
    }
    /**
     * @param array<int, Type> $classParameterTypes
     */
    public function complete(\PhpParser\Node\Stmt\ClassMethod $classMethod, array $classParameterTypes) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $hasChanged = \false;
        foreach ($classParameterTypes as $position => $argumentStaticType) {
            if ($this->shouldSkipArgumentStaticType($classMethod, $argumentStaticType, $position)) {
                continue;
            }
            $phpParserTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($argumentStaticType);
            if ($phpParserTypeNode === null) {
                continue;
            }
            // update parameter
            $classMethod->params[$position]->type = $phpParserTypeNode;
            $hasChanged = \true;
        }
        if ($hasChanged) {
            return $classMethod;
        }
        return null;
    }
    private function shouldSkipArgumentStaticType(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PHPStan\Type\Type $argumentStaticType, int $position) : bool
    {
        if ($argumentStaticType instanceof \PHPStan\Type\MixedType) {
            return \true;
        }
        if (!isset($classMethod->params[$position])) {
            return \true;
        }
        if ($this->classMethodParamVendorLockResolver->isVendorLocked($classMethod, $position)) {
            return \true;
        }
        $parameter = $classMethod->params[$position];
        if ($parameter->type === null) {
            return \false;
        }
        $parameterStaticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($parameter->type);
        // already completed → skip
        return $parameterStaticType->equals($argumentStaticType);
    }
}
