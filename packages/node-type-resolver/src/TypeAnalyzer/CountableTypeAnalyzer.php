<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\TypeAnalyzer;

use Countable;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector $pregMatchTypeCorrector)
    {
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
        $this->pregMatchTypeCorrector = $pregMatchTypeCorrector;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isCountableType(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $nodeType = $this->nodeTypeResolver->resolve($node);
        $nodeType = $this->pregMatchTypeCorrector->correct($node, $nodeType);
        if ($this->isCountableObjectType($nodeType)) {
            return \true;
        }
        return $this->arrayTypeAnalyzer->isArrayType($node);
    }
    private function isCountableObjectType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
    {
        $countableObjectTypes = [new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType(\Countable::class), new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType('SimpleXMLElement'), new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType('ResourceBundle')];
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            return $this->isCountableUnionType($type, $countableObjectTypes);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
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
    private function isCountableUnionType(\_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType $unionType, array $countableObjectTypes) : bool
    {
        if ($unionType->isSubTypeOf(new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType())->yes()) {
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
