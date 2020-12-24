<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_;

use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
final class EmbeddedTagValueNode extends \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode
{
    /**
     * @var string
     */
    private $fullyQualifiedClassName;
    public function __construct(array $items, ?string $originalContent, string $fullyQualifiedClassName)
    {
        parent::__construct($items, $originalContent);
        $this->fullyQualifiedClassName = $fullyQualifiedClassName;
    }
    public function getShortName() : string
    {
        return '_PhpScoper2a4e7ab1ecbc\\@ORM\\Embedded';
    }
    public function getClass() : string
    {
        return $this->items['class'];
    }
    public function getFullyQualifiedClassName() : string
    {
        return $this->fullyQualifiedClassName;
    }
    public function getColumnPrefix() : ?string
    {
        return $this->items['columnPrefix'];
    }
}
