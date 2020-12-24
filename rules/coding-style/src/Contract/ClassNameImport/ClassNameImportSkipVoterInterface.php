<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Contract\ClassNameImport;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
interface ClassNameImportSkipVoterInterface
{
    public function shouldSkip(\_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScopere8e811afab72\PhpParser\Node $node) : bool;
}
