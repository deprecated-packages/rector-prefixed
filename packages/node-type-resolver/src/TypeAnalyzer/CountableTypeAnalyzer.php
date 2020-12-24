<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer;

use Countable;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class CountableTypeAnalyzer
{
    /**
     * @var ArrayTypeAnalyzer
     */
    private $arrayTypeAnalyzer;
    /**
     * @var PregMatchTypeCorrector
     */
    private $pregMatchTypeCorrector;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector $pregMatchTypeCorrector)
    {
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
        $this->pregMatchTypeCorrector = $pregMatchTypeCorrector;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isCountableType(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $nodeType = $this->nodeTypeResolver->resolve($node);
        $nodeType = $this->pregMatchTypeCorrector->correct($node, $nodeType);
        if ($this->isCountableObjectType($nodeType)) {
            return \true;
        }
        return $this->arrayTypeAnalyzer->isArrayType($node);
    }
    private function isCountableObjectType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        $countableObjectTypes = [new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\Countable::class), new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType('SimpleXMLElement'), new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType('ResourceBundle')];
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return $this->isCountableUnionType($type, $countableObjectTypes);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            foreach ($countableObjectTypes as $countableObjectType) {
                if (!\is_a($type->getClassName(), $countableObjectType->getClassName(), \true)) {
                    continue;
                }
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param ObjectType[] $countableObjectTypes
     */
    private function isCountableUnionType(\_PhpScopere8e811afab72\PHPStan\Type\UnionType $unionType, array $countableObjectTypes) : bool
    {
        if ($unionType->isSubTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\NullType())->yes()) {
            return \false;
        }
        foreach ($countableObjectTypes as $countableObjectType) {
            if ($unionType->isSuperTypeOf($countableObjectType)->yes()) {
                return \true;
            }
        }
        return \false;
    }
}
