<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic;
class TeamCity extends \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('TEAMCITY_VERSION') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector::CI_TEAMCITY;
    }
    public function isPullRequest() : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic::createMaybe();
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('BUILD_NUMBER');
    }
    public function getBuildUrl() : string
    {
        return '';
        // unsupported
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('BUILD_VCS_NUMBER');
    }
    public function getGitBranch() : string
    {
        return '';
        // unsupported
    }
    public function getRepositoryName() : string
    {
        return '';
        // unsupported
    }
    public function getRepositoryUrl() : string
    {
        return '';
        // unsupported
    }
}
