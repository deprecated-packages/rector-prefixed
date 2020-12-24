<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Contract\ClassNameImport;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
interface ClassNameImportSkipVoterInterface
{
    public function shouldSkip(\_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool;
}
