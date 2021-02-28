<?php

declare (strict_types=1);
namespace Rector\Naming\PropertyRenamer;

use PhpParser\Node\Stmt\Property;
use Rector\Naming\Guard\PropertyConflictingNameGuard\UnderscoreCamelCaseConflictingNameGuard;
use Rector\Naming\ValueObject\PropertyRename;
final class UnderscoreCamelCasePropertyRenamer extends \Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    /**
     * @var UnderscoreCamelCaseConflictingNameGuard
     */
    private $underscoreCamelCaseConflictingNameGuard;
    public function __construct(\Rector\Naming\Guard\PropertyConflictingNameGuard\UnderscoreCamelCaseConflictingNameGuard $underscoreCamelCaseConflictingNameGuard)
    {
        $this->underscoreCamelCaseConflictingNameGuard = $underscoreCamelCaseConflictingNameGuard;
    }
    public function rename(\Rector\Naming\ValueObject\PropertyRename $propertyRename) : ?\PhpParser\Node\Stmt\Property
    {
        if ($this->underscoreCamelCaseConflictingNameGuard->isConflicting($propertyRename)) {
            return null;
        }
        return parent::rename($propertyRename);
    }
}
