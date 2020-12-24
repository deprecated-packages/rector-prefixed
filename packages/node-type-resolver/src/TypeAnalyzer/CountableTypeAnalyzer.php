<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer;

use Countable;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeCorrector\PregMatchTypeCorrector $pregMatchTypeCorrector)
    {
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
        $this->pregMatchTypeCorrector = $pregMatchTypeCorrector;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isCountableType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $nodeType = $this->nodeTypeResolver->resolve($node);
        $nodeType = $this->pregMatchTypeCorrector->correct($node, $nodeType);
        if ($this->isCountableObjectType($nodeType)) {
            return \true;
        }
        return $this->arrayTypeAnalyzer->isArrayType($node);
    }
    private function isCountableObjectType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        $countableObjectTypes = [new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\Countable::class), new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType('SimpleXMLElement'), new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType('ResourceBundle')];
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return $this->isCountableUnionType($type, $countableObjectTypes);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
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
    private function isCountableUnionType(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType, array $countableObjectTypes) : bool
    {
        if ($unionType->isSubTypeOf(new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType())->yes()) {
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
