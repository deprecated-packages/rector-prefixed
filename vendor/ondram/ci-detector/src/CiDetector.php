<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\OndraM\CiDetector;

use _PhpScopera143bcca66cb\OndraM\CiDetector\Ci\CiInterface;
use _PhpScopera143bcca66cb\OndraM\CiDetector\Exception\CiNotDetectedException;
/**
 * Unified way to get environment variables from current continuous integration server
 */
class CiDetector
{
    public const CI_APPVEYOR = 'AppVeyor';
    public const CI_AWS_CODEBUILD = 'AWS CodeBuild';
    public const CI_BAMBOO = 'Bamboo';
    public const CI_BITBUCKET_PIPELINES = 'Bitbucket Pipelines';
    public const CI_BUDDY = 'Buddy';
    public const CI_CIRCLE = 'CircleCI';
    public const CI_CODESHIP = 'Codeship';
    public const CI_CONTINUOUSPHP = 'continuousphp';
    public const CI_DRONE = 'drone';
    public const CI_GITHUB_ACTIONS = 'GitHub Actions';
    public const CI_GITLAB = 'GitLab';
    public const CI_JENKINS = 'Jenkins';
    public const CI_TEAMCITY = 'TeamCity';
    public const CI_TRAVIS = 'Travis CI';
    public const CI_WERCKER = 'Wercker';
    /** @var Env */
    private $environment;
    public function __construct()
    {
        $this->environment = new \_PhpScopera143bcca66cb\OndraM\CiDetector\Env();
    }
    public static function fromEnvironment(\_PhpScopera143bcca66cb\OndraM\CiDetector\Env $environment) : self
    {
        $detector = new static();
        $detector->environment = $environment;
        return $detector;
    }
    /**
     * Is current environment an recognized CI server?
     */
    public function isCiDetected() : bool
    {
        $ciServer = $this->detectCurrentCiServer();
        return $ciServer !== null;
    }
    /**
     * Detect current CI server and return instance of its settings
     *
     * @throws CiNotDetectedException
     */
    public function detect() : \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\CiInterface
    {
        $ciServer = $this->detectCurrentCiServer();
        if ($ciServer === null) {
            throw new \_PhpScopera143bcca66cb\OndraM\CiDetector\Exception\CiNotDetectedException('No CI server detected in current environment');
        }
        return $ciServer;
    }
    /**
     * @return string[]
     */
    protected function getCiServers() : array
    {
        return [\_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\AppVeyor::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\AwsCodeBuild::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\Bamboo::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\BitbucketPipelines::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\Buddy::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\Circle::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\Codeship::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\Continuousphp::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\Drone::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\GitHubActions::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\GitLab::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\Jenkins::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\TeamCity::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\Travis::class, \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\Wercker::class];
    }
    protected function detectCurrentCiServer() : ?\_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\CiInterface
    {
        $ciServers = $this->getCiServers();
        foreach ($ciServers as $ciClass) {
            $callback = [$ciClass, 'isDetected'];
            if (\is_callable($callback)) {
                if ($callback($this->environment)) {
                    return new $ciClass($this->environment);
                }
            }
        }
        return null;
    }
}
