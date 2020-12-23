<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\NodeFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory;
final class MissingPropertiesFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var PropertyTypeDecorator
     */
    private $propertyTypeDecorator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a2ac50786fa\Rector\CodeQuality\NodeFactory\PropertyTypeDecorator $propertyTypeDecorator)
    {
        $this->nodeFactory = $nodeFactory;
        $this->propertyTypeDecorator = $propertyTypeDecorator;
    }
    /**
     * @param array<string, Type> $fetchedLocalPropertyNameToTypes
     * @param string[] $propertyNamesToComplete
     * @return Property[]
     */
    public function create(array $fetchedLocalPropertyNameToTypes, array $propertyNamesToComplete) : array
    {
        $newProperties = [];
        foreach ($fetchedLocalPropertyNameToTypes as $propertyName => $propertyType) {
            if (!\in_array($propertyName, $propertyNamesToComplete, \true)) {
                continue;
            }
            $property = $this->nodeFactory->createPublicProperty($propertyName);
            $this->propertyTypeDecorator->decorateProperty($property, $propertyType);
            $newProperties[] = $property;
        }
        return $newProperties;
    }
}
