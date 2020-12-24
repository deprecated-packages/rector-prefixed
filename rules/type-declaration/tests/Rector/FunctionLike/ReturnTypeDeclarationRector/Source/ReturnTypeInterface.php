<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\FunctionLike\ReturnTypeDeclarationRector\Source;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
interface ReturnTypeInterface
{
    /**
     * @return String_|null
     */
    public function getNode() : ?\_PhpScoperb75b35f52b74\PhpParser\Node;
}
