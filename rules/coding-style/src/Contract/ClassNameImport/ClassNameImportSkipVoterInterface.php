<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Contract\ClassNameImport;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
interface ClassNameImportSkipVoterInterface
{
    public function shouldSkip(\_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool;
}
