<?php

declare (strict_types=1);
namespace Rector\Core\Rector\AbstractRector;

use RectorPrefix20210120\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\ChangesReporting\Rector\AbstractRector\NotifyingRemovingNodeTrait;
use Rector\FileSystemRector\Behavior\FileSystemRectorTrait;
use Rector\PostRector\Rector\AbstractRector\NodeCommandersTrait;
trait AbstractRectorTrait
{
    use FileSystemRectorTrait;
    use PhpDocTrait;
    use RemovedAndAddedFilesTrait;
    use NodeTypeResolverTrait;
    use NameResolverTrait;
    use ConstFetchAnalyzerTrait;
    use BetterStandardPrinterTrait;
    use NodeCommandersTrait;
    use NodeFactoryTrait;
    use VisibilityTrait;
    use ValueResolverTrait;
    use SimpleCallableNodeTraverserTrait;
    use ComplexRemovalTrait;
    use NodeCollectorTrait;
    use NotifyingRemovingNodeTrait;
    protected function isNonAnonymousClass(\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        $name = $this->getName($node);
        if ($name === null) {
            return \false;
        }
        return !\RectorPrefix20210120\Nette\Utils\Strings::contains($name, 'AnonymousClass');
    }
    protected function removeFinal(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->flags -= \PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
    }
}
