<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\SetConfigResolver\ValueObject;

use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class Set
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var SmartFileInfo
     */
    private $setFileInfo;
    public function __construct(string $name, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $setFileInfo)
    {
        $this->name = $name;
        $this->setFileInfo = $setFileInfo;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getSetFileInfo() : \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->setFileInfo;
    }
    public function getSetPathname() : string
    {
        return $this->setFileInfo->getPathname();
    }
}
