<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\ChangesReporting\Rector\AbstractRector\NotifyingRemovingNodeTrait;
use _PhpScopere8e811afab72\Rector\Doctrine\AbstractRector\DoctrineTrait;
use _PhpScopere8e811afab72\Rector\FileSystemRector\Behavior\FileSystemRectorTrait;
use _PhpScopere8e811afab72\Rector\PostRector\Rector\AbstractRector\NodeCommandersTrait;
trait AbstractRectorTrait
{
    use FileSystemRectorTrait;
    use PhpDocTrait;
    use RemovedAndAddedFilesTrait;
    use DoctrineTrait;
    use NodeTypeResolverTrait;
    use NameResolverTrait;
    use ConstFetchAnalyzerTrait;
    use BetterStandardPrinterTrait;
    use NodeCommandersTrait;
    use NodeFactoryTrait;
    use VisibilityTrait;
    use ValueResolverTrait;
    use CallableNodeTraverserTrait;
    use ComplexRemovalTrait;
    use NodeCollectorTrait;
    use NotifyingRemovingNodeTrait;
    protected function isNonAnonymousClass(?\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if ($node === null) {
            return \false;
        }
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        $name = $this->getName($node);
        if ($name === null) {
            return \false;
        }
        return !\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($name, 'AnonymousClass');
    }
    protected function removeFinal(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->flags -= \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
    }
}
