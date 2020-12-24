<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Tests\Rector\FunctionLike\ReturnTypeDeclarationRector\Source;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
interface ReturnTypeInterface
{
    /**
     * @return String_|null
     */
    public function getNode() : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node;
}
