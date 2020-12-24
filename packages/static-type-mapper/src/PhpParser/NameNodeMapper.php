<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpParser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\StaticType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\PSR4\Collector\RenamedClassesCollector;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class NameNodeMapper implements \_PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector)
    {
        $this->renamedClassesCollector = $renamedClassesCollector;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Name::class;
    }
    /**
     * @param Name $node
     */
    public function mapToPHPStan(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $name = $node->toString();
        if ($this->isExistingClass($name)) {
            return new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($name);
        }
        if ($name === 'static') {
            $className = (string) $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            return new \_PhpScopere8e811afab72\PHPStan\Type\StaticType($className);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    private function isExistingClass(string $name) : bool
    {
        if (\_PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($name)) {
            return \true;
        }
        // to be existing class names
        $oldToNewClasses = $this->renamedClassesCollector->getOldToNewClasses();
        return \in_array($name, $oldToNewClasses, \true);
    }
}
