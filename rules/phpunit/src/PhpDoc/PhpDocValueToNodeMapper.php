<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\PhpDoc;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory;
final class PhpDocValueToNodeMapper
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function mapGenericTagValueNode(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode $genericTagValueNode) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($genericTagValueNode->value, '::')) {
            [$class, $constant] = \explode('::', $genericTagValueNode->value);
            return $this->nodeFactory->createShortClassConstFetch($class, $constant);
        }
        $reference = \ltrim($genericTagValueNode->value, '\\');
        if (\class_exists($reference)) {
            return $this->nodeFactory->createClassConstReference($reference);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_($reference);
    }
}
