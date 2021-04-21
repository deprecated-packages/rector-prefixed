<?php

declare(strict_types=1);

namespace Rector\Doctrine\TypeAnalyzer;

use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;

final class CollectionVarTagValueNodeResolver
{
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;

    public function __construct(PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }

    /**
     * @return \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode|null
     */
    public function resolve(Property $property)
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        if (! $phpDocInfo->hasByAnnotationClass('Doctrine\ORM\Mapping\OneToMany')) {
            return null;
        }

        return $phpDocInfo->getVarTagValueNode();
    }
}
