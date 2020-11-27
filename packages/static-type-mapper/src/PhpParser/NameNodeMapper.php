<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\PhpParser;

use PhpParser\Node;
use PhpParser\Node\Name;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use Rector\PHPStan\Type\FullyQualifiedObjectType;
use Rector\PSR4\Collector\RenamedClassesCollector;
use Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class NameNodeMapper implements \Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    public function __construct(\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector)
    {
        $this->renamedClassesCollector = $renamedClassesCollector;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Name::class;
    }
    /**
     * @param Name $node
     */
    public function mapToPHPStan(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        $name = $node->toString();
        if ($this->isExistingClass($name)) {
            return new \Rector\PHPStan\Type\FullyQualifiedObjectType($name);
        }
        return new \PHPStan\Type\MixedType();
    }
    private function isExistingClass(string $name) : bool
    {
        if (\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($name)) {
            return \true;
        }
        // to be existing class names
        $oldToNewClasses = $this->renamedClassesCollector->getOldToNewClasses();
        return \in_array($name, $oldToNewClasses, \true);
    }
}
