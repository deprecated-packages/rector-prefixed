<?php

declare (strict_types=1);
namespace Rector\Composer\Tests\Version;

use RectorPrefix20210113\PHPUnit\Framework\TestCase;
use Rector\Composer\ValueObject\Version\Version;
use UnexpectedValueException;
final class VersionTest extends \RectorPrefix20210113\PHPUnit\Framework\TestCase
{
    public function testExactVersion() : void
    {
        $version = new \Rector\Composer\ValueObject\Version\Version('1.2.3');
        $this->assertInstanceOf(\Rector\Composer\ValueObject\Version\Version::class, $version);
        $this->assertSame('1.2.3', $version->getVersion());
    }
    public function testTildeVersion() : void
    {
        $version = new \Rector\Composer\ValueObject\Version\Version('~1.2.3');
        $this->assertInstanceOf(\Rector\Composer\ValueObject\Version\Version::class, $version);
        $this->assertSame('~1.2.3', $version->getVersion());
    }
    public function testCaretVersion() : void
    {
        $version = new \Rector\Composer\ValueObject\Version\Version('^1.2.3');
        $this->assertInstanceOf(\Rector\Composer\ValueObject\Version\Version::class, $version);
        $this->assertSame('^1.2.3', $version->getVersion());
    }
    public function testDevMasterAsVersion() : void
    {
        $version = new \Rector\Composer\ValueObject\Version\Version('dev-master as 1.2.3');
        $this->assertInstanceOf(\Rector\Composer\ValueObject\Version\Version::class, $version);
        $this->assertSame('dev-master as 1.2.3', $version->getVersion());
    }
    public function testWrongAliasVersion() : void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Could not parse version constraint AS: Invalid version string "AS"');
        new \Rector\Composer\ValueObject\Version\Version('dev-master AS 1.2.3');
    }
}
