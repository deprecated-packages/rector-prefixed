<?php

declare (strict_types=1);
namespace RectorPrefix20210307\Symplify\SmartFileSystem\Tests\SmartFileSystem;

use RectorPrefix20210307\PHPUnit\Framework\TestCase;
use RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileSystem;
final class SmartFileSystemTest extends \RectorPrefix20210307\PHPUnit\Framework\TestCase
{
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    protected function setUp() : void
    {
        $this->smartFileSystem = new \RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileSystem();
    }
    public function testReadFileToSmartFileInfo() : void
    {
        $readFileToSmartFileInfo = $this->smartFileSystem->readFileToSmartFileInfo(__DIR__ . '/Source/file.txt');
        $this->assertInstanceof(\RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileInfo::class, $readFileToSmartFileInfo);
    }
}
