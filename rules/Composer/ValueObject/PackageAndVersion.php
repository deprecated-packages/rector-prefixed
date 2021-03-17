<?php

declare (strict_types=1);
namespace Rector\Composer\ValueObject;

use Rector\Composer\Contract\VersionAwareInterface;
final class PackageAndVersion implements \Rector\Composer\Contract\VersionAwareInterface
{
    /**
     * @var string
     */
    private $packageName;
    /**
     * @var string
     */
    private $version;
    /**
     * @param string $packageName
     * @param string $version
     */
    public function __construct($packageName, $version)
    {
        $this->packageName = $packageName;
        $this->version = $version;
    }
    public function getPackageName() : string
    {
        return $this->packageName;
    }
    public function getVersion() : string
    {
        return $this->version;
    }
}
