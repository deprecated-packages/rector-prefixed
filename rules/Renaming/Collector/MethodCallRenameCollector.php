<?php

namespace Rector\Renaming\Collector;

use Rector\Renaming\Contract\MethodCallRenameInterface;

final class MethodCallRenameCollector
{
    /**
     * @var MethodCallRenameInterface[]
     */
    private $methodCallRenames = [];

    /**
     * @return void
     */
    public function addMethodCallRename(MethodCallRenameInterface $methodCallRename)
    {
        $this->methodCallRenames[] = $methodCallRename;
    }

    /**
     * @return MethodCallRenameInterface[]
     */
    public function getMethodCallRenames(): array
    {
        return $this->methodCallRenames;
    }
}
