<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper\ArrayTypeMapper;
final class AttributeAwareArrayTypeNode extends \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
    public function __toString() : string
    {
        if ($this->type instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode) {
            return \sprintf('(%s)[]', (string) $this->type);
        }
        $typeAsString = (string) $this->type;
        if ($this->isGenericArrayCandidate($this->type)) {
            return \sprintf('array<%s>', $typeAsString);
        }
        if ($this->type instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
            return $this->printArrayType($this->type);
        }
        if ($this->type instanceof \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode) {
            return $this->printUnionType($this->type);
        }
        return $typeAsString . '[]';
    }
    private function isGenericArrayCandidate(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : bool
    {
        if (!$this->getAttribute(\_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper\ArrayTypeMapper::HAS_GENERIC_TYPE_PARENT)) {
            return \false;
        }
        return $typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode || $typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
    }
    private function printArrayType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode $arrayTypeNode) : string
    {
        $typeAsString = (string) $arrayTypeNode;
        $singleTypesAsString = \explode('|', $typeAsString);
        foreach ($singleTypesAsString as $key => $singleTypeAsString) {
            $singleTypesAsString[$key] = $singleTypeAsString . '[]';
        }
        return \implode('|', $singleTypesAsString);
    }
    private function printUnionType(\_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode $attributeAwareUnionTypeNode) : string
    {
        $unionedTypes = [];
        if ($attributeAwareUnionTypeNode->isWrappedWithBrackets()) {
            return $attributeAwareUnionTypeNode . '[]';
        }
        foreach ($attributeAwareUnionTypeNode->types as $unionedType) {
            $unionedTypes[] = $unionedType . '[]';
        }
        return \implode('|', $unionedTypes);
    }
}
