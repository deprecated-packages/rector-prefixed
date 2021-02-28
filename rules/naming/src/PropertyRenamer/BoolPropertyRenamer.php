<?php

declare (strict_types=1);
namespace Rector\Naming\PropertyRenamer;

use PhpParser\Node\Stmt\Property;
use Rector\Naming\Guard\PropertyConflictingNameGuard\BoolPropertyConflictingNameGuard;
use Rector\Naming\ValueObject\PropertyRename;
final class BoolPropertyRenamer extends \Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    /**
     * @var BoolPropertyConflictingNameGuard
     */
    private $boolPropertyConflictingNameGuard;
    public function __construct(\Rector\Naming\Guard\PropertyConflictingNameGuard\BoolPropertyConflictingNameGuard $boolPropertyConflictingNameGuard)
    {
        $this->boolPropertyConflictingNameGuard = $boolPropertyConflictingNameGuard;
    }
    public function rename(\Rector\Naming\ValueObject\PropertyRename $propertyRename) : ?\PhpParser\Node\Stmt\Property
    {
        if ($this->boolPropertyConflictingNameGuard->isConflicting($propertyRename)) {
            return null;
        }
        return parent::rename($propertyRename);
    }
}
