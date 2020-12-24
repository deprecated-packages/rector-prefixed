<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\FunctionLike\ReturnTypeDeclarationRector\Source;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
interface ReturnTypeInterface
{
    /**
     * @return String_|null
     */
    public function getNode() : ?\_PhpScopere8e811afab72\PhpParser\Node;
}
