<?php

declare (strict_types=1);
namespace Rector\Composer\Guard;

use RectorPrefix20210420\Composer\Semver\VersionParser;
use Rector\Composer\Contract\VersionAwareInterface;
final class VersionGuard
{
    /**
     * @var VersionParser
     */
    private $versionParser;
    public function __construct(\RectorPrefix20210420\Composer\Semver\VersionParser $versionParser)
    {
        $this->versionParser = $versionParser;
    }
    /**
     * @param VersionAwareInterface[] $versionAwares
     * @return void
     */
    public function validate(array $versionAwares)
    {
        foreach ($versionAwares as $versionAware) {
            $this->versionParser->parseConstraints($versionAware->getVersion());
        }
    }
}
