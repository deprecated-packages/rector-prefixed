<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\Rector\ChangesReporting\Rector\AbstractRector\NotifyingRemovingNodeTrait;
use _PhpScoperb75b35f52b74\Rector\Doctrine\AbstractRector\DoctrineTrait;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\Behavior\FileSystemRectorTrait;
use _PhpScoperb75b35f52b74\Rector\PostRector\Rector\AbstractRector\NodeCommandersTrait;
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
    protected function isNonAnonymousClass(?\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if ($node === null) {
            return \false;
        }
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        $name = $this->getName($node);
        if ($name === null) {
            return \false;
        }
        return !\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($name, 'AnonymousClass');
    }
    protected function removeFinal(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->flags -= \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
    }
}
