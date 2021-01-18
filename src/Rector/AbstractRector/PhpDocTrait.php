<?php

declare (strict_types=1);
namespace Rector\Core\Rector\AbstractRector;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoManipulator;
use Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait PhpDocTrait
{
    /**
     * @var PhpDocInfoPrinter
     */
    protected $phpDocInfoPrinter;
    /**
     * @var PhpDocInfoFactory
     */
    protected $phpDocInfoFactory;
    /**
     * @var PhpDocInfoManipulator
     */
    protected $phpDocInfoManipulator;
    /**
     * @required
     */
    public function autowirePhpDocTrait(\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter $phpDocInfoPrinter, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoManipulator $phpDocInfoManipulator) : void
    {
        $this->phpDocInfoPrinter = $phpDocInfoPrinter;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->phpDocInfoManipulator = $phpDocInfoManipulator;
    }
    protected function hasTagByName(\PhpParser\Node $node, string $tagName) : bool
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        return $phpDocInfo->hasByName($tagName);
    }
    protected function getPhpDocTagValueNode(\PhpParser\Node $node, string $phpDocTagNodeClass) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        return $this->phpDocInfoManipulator->getPhpDocTagValueNode($node, $phpDocTagNodeClass);
    }
    protected function hasPhpDocTagValueNode(\PhpParser\Node $node, string $phpDocTagNodeClass) : bool
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        return $phpDocInfo->hasByType($phpDocTagNodeClass);
    }
    protected function removePhpDocTagValueNode(\PhpParser\Node $node, string $phpDocTagNodeClass) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        $phpDocInfo->removeByType($phpDocTagNodeClass);
    }
}
