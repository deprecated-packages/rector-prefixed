<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpParser;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a6b37af0871\Rector\PSR4\Collector\RenamedClassesCollector;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class NameNodeMapper implements \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector)
    {
        $this->renamedClassesCollector = $renamedClassesCollector;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Name::class;
    }
    /**
     * @param Name $node
     */
    public function mapToPHPStan(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $name = $node->toString();
        if ($this->isExistingClass($name)) {
            return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($name);
        }
        if ($name === 'static') {
            $className = (string) $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType($className);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
    private function isExistingClass(string $name) : bool
    {
        if (\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($name)) {
            return \true;
        }
        // to be existing class names
        $oldToNewClasses = $this->renamedClassesCollector->getOldToNewClasses();
        return \in_array($name, $oldToNewClasses, \true);
    }
}
