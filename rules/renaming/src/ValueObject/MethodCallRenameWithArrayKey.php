<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject;

use _PhpScoper0a2ac50786fa\Rector\Renaming\Contract\MethodCallRenameInterface;
final class MethodCallRenameWithArrayKey implements \_PhpScoper0a2ac50786fa\Rector\Renaming\Contract\MethodCallRenameInterface
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
    /**
     * @var mixed
     */
    private $arrayKey;
    /**
     * @param mixed $arrayKey
     */
    public function __construct(string $oldClass, string $oldMethod, string $newMethod, $arrayKey)
    {
        $this->oldClass = $oldClass;
        $this->oldMethod = $oldMethod;
        $this->newMethod = $newMethod;
        $this->arrayKey = $arrayKey;
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
    /**
     * @return mixed
     */
    public function getArrayKey()
    {
        return $this->arrayKey;
    }
}
