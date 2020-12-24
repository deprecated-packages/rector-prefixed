<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer;
final class AllAssignNodePropertyTypeInferer extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var AssignToPropertyTypeInferer
     */
    private $assignToPropertyTypeInferer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer $assignToPropertyTypeInferer)
    {
        $this->assignToPropertyTypeInferer = $assignToPropertyTypeInferer;
    }
    public function inferProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var ClassLike|null $classLike */
        $classLike = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            // anonymous class
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $propertyName = $this->nodeNameResolver->getName($property);
        return $this->assignToPropertyTypeInferer->inferPropertyInClassLike($propertyName, $classLike);
    }
    public function getPriority() : int
    {
        return 1500;
    }
}
