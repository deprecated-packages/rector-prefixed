<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject;

use _PhpScoperb75b35f52b74\Rector\Renaming\Contract\MethodCallRenameInterface;
final class MethodCallRename implements \_PhpScoperb75b35f52b74\Rector\Renaming\Contract\MethodCallRenameInterface
{
    /**
     * @var string
     */
    private $oldClass;
    /**
     * @var string
     */
    private $oldMethod;
    /**
     * @var string
     */
    private $newMethod;
    public function __construct(string $oldClass, string $oldMethod, string $newMethod)
    {
        $this->oldClass = $oldClass;
        $this->oldMethod = $oldMethod;
        $this->newMethod = $newMethod;
    }
    public function getOldClass() : string
    {
        return $this->oldClass;
    }
    public function getOldMethod() : string
    {
        return $this->oldMethod;
    }
    public function getNewMethod() : string
    {
        return $this->newMethod;
    }
}
