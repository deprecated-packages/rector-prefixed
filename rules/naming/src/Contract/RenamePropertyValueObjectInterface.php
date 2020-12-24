<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Contract;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty;
interface RenamePropertyValueObjectInterface extends \_PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface
{
    public function getClassLike() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
    public function getClassLikeName() : string;
    public function getProperty() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
    public function getPropertyProperty() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty;
}
