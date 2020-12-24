<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\ChangesReporting\Rector\AbstractRector\NotifyingRemovingNodeTrait;
use _PhpScoper0a6b37af0871\Rector\Doctrine\AbstractRector\DoctrineTrait;
use _PhpScoper0a6b37af0871\Rector\FileSystemRector\Behavior\FileSystemRectorTrait;
use _PhpScoper0a6b37af0871\Rector\PostRector\Rector\AbstractRector\NodeCommandersTrait;
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
    protected function isNonAnonymousClass(?\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if ($node === null) {
            return \false;
        }
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        $name = $this->getName($node);
        if ($name === null) {
            return \false;
        }
        return !\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($name, 'AnonymousClass');
    }
    protected function removeFinal(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->flags -= \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
    }
}
