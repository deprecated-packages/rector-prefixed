<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Contract\ExpectedNameResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
interface ExpectedNameResolverInterface
{
    /**
     * @param Param|Property $node
     */
    public function resolveIfNotYet(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string;
    /**
     * @param Param|Property $node
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string;
}
