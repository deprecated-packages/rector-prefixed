<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpParser;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\PSR4\Collector\RenamedClassesCollector;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class NameNodeMapper implements \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector)
    {
        $this->renamedClassesCollector = $renamedClassesCollector;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Name::class;
    }
    /**
     * @param Name $node
     */
    public function mapToPHPStan(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $name = $node->toString();
        if ($this->isExistingClass($name)) {
            return new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($name);
        }
        if ($name === 'static') {
            $className = (string) $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType($className);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    private function isExistingClass(string $name) : bool
    {
        if (\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($name)) {
            return \true;
        }
        // to be existing class names
        $oldToNewClasses = $this->renamedClassesCollector->getOldToNewClasses();
        return \in_array($name, $oldToNewClasses, \true);
    }
}
