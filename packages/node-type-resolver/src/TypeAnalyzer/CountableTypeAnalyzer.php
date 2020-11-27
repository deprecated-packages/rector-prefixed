<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\TypeAnalyzer;

use Countable;
use PhpParser\Node;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector;
use Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector $pregMatchTypeCorrector)
    {
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
        $this->pregMatchTypeCorrector = $pregMatchTypeCorrector;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isCountableType(\PhpParser\Node $node) : bool
    {
        $nodeType = $this->nodeTypeResolver->resolve($node);
        $nodeType = $this->pregMatchTypeCorrector->correct($node, $nodeType);
        if ($this->isCountableObjectType($nodeType)) {
            return \true;
        }
        return $this->arrayTypeAnalyzer->isArrayType($node);
    }
    private function isCountableObjectType(\PHPStan\Type\Type $type) : bool
    {
        $countableObjectTypes = [new \PHPStan\Type\ObjectType(\Countable::class), new \PHPStan\Type\ObjectType('SimpleXMLElement'), new \PHPStan\Type\ObjectType('ResourceBundle')];
        if ($type instanceof \PHPStan\Type\UnionType) {
            return $this->isCountableUnionType($type, $countableObjectTypes);
        }
        if ($type instanceof \PHPStan\Type\ObjectType) {
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
    private function isCountableUnionType(\PHPStan\Type\UnionType $unionType, array $countableObjectTypes) : bool
    {
        if ($unionType->isSubTypeOf(new \PHPStan\Type\NullType())->yes()) {
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
