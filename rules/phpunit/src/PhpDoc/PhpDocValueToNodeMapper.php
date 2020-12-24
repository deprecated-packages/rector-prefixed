<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\PhpDoc;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory;
final class PhpDocValueToNodeMapper
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function mapGenericTagValueNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode $genericTagValueNode) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($genericTagValueNode->value, '::')) {
            [$class, $constant] = \explode('::', $genericTagValueNode->value);
            return $this->nodeFactory->createShortClassConstFetch($class, $constant);
        }
        $reference = \ltrim($genericTagValueNode->value, '\\');
        if (\class_exists($reference)) {
            return $this->nodeFactory->createClassConstReference($reference);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($reference);
    }
}
