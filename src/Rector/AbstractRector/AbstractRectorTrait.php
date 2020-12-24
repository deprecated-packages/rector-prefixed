<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\Rector\ChangesReporting\Rector\AbstractRector\NotifyingRemovingNodeTrait;
use _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\AbstractRector\DoctrineTrait;
use _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Behavior\FileSystemRectorTrait;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Rector\AbstractRector\NodeCommandersTrait;
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
    protected function isNonAnonymousClass(?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        if ($node === null) {
            return \false;
        }
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        $name = $this->getName($node);
        if ($name === null) {
            return \false;
        }
        return !\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($name, 'AnonymousClass');
    }
    protected function removeFinal(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->flags -= \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
    }
}
