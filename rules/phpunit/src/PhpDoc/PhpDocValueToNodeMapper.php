<?php

declare (strict_types=1);
namespace Rector\PHPUnit\PhpDoc;

use RectorPrefix20210225\Nette\Utils\Strings;
use PhpParser\Node\Expr;
use PhpParser\Node\Scalar\String_;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use Rector\Core\PhpParser\Node\NodeFactory;
final class PhpDocValueToNodeMapper
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function mapGenericTagValueNode(\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode $genericTagValueNode) : \PhpParser\Node\Expr
    {
        if (\RectorPrefix20210225\Nette\Utils\Strings::contains($genericTagValueNode->value, '::')) {
            [$class, $constant] = \explode('::', $genericTagValueNode->value);
            return $this->nodeFactory->createShortClassConstFetch($class, $constant);
        }
        $reference = \ltrim($genericTagValueNode->value, '\\');
        if (\class_exists($reference)) {
            return $this->nodeFactory->createClassConstReference($reference);
        }
        return new \PhpParser\Node\Scalar\String_($reference);
    }
}
