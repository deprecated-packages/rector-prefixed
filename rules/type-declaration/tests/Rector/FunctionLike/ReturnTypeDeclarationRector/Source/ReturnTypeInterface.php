<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests\Rector\FunctionLike\ReturnTypeDeclarationRector\Source;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
interface ReturnTypeInterface
{
    /**
     * @return String_|null
     */
    public function getNode() : ?\_PhpScoper0a6b37af0871\PhpParser\Node;
}
