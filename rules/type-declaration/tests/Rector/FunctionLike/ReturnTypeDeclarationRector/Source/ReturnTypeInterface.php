<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Tests\Rector\FunctionLike\ReturnTypeDeclarationRector\Source;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
interface ReturnTypeInterface
{
    /**
     * @return String_|null
     */
    public function getNode() : ?\_PhpScoper0a2ac50786fa\PhpParser\Node;
}
