<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\OndraM\CiDetector\Ci;

use _PhpScoper26e51eeacccf\OndraM\CiDetector\CiDetector;
use _PhpScoper26e51eeacccf\OndraM\CiDetector\Env;
use _PhpScoper26e51eeacccf\OndraM\CiDetector\TrinaryLogic;
class TeamCity extends \_PhpScoper26e51eeacccf\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoper26e51eeacccf\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('TEAMCITY_VERSION') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoper26e51eeacccf\OndraM\CiDetector\CiDetector::CI_TEAMCITY;
    }
    public function isPullRequest() : \_PhpScoper26e51eeacccf\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoper26e51eeacccf\OndraM\CiDetector\TrinaryLogic::createMaybe();
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
