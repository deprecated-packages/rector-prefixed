<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer;
final class AllAssignNodePropertyTypeInferer extends \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var AssignToPropertyTypeInferer
     */
    private $assignToPropertyTypeInferer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\AssignToPropertyTypeInferer $assignToPropertyTypeInferer)
    {
        $this->assignToPropertyTypeInferer = $assignToPropertyTypeInferer;
    }
    public function inferProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        /** @var ClassLike|null $classLike */
        $classLike = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            // anonymous class
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        $propertyName = $this->nodeNameResolver->getName($property);
        return $this->assignToPropertyTypeInferer->inferPropertyInClassLike($propertyName, $classLike);
    }
    public function getPriority() : int
    {
        return 1500;
    }
}
