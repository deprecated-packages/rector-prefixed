<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\PhpDoc;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
final class PhpDocValueToNodeMapper
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function mapGenericTagValueNode(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode $genericTagValueNode) : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($genericTagValueNode->value, '::')) {
            [$class, $constant] = \explode('::', $genericTagValueNode->value);
            return $this->nodeFactory->createShortClassConstFetch($class, $constant);
        }
        $reference = \ltrim($genericTagValueNode->value, '\\');
        if (\class_exists($reference)) {
            return $this->nodeFactory->createClassConstReference($reference);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($reference);
    }
}
