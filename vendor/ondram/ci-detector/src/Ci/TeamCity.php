<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\OndraM\CiDetector\Ci;

use _PhpScoper006a73f0e455\OndraM\CiDetector\CiDetector;
use _PhpScoper006a73f0e455\OndraM\CiDetector\Env;
use _PhpScoper006a73f0e455\OndraM\CiDetector\TrinaryLogic;
class TeamCity extends \_PhpScoper006a73f0e455\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoper006a73f0e455\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('TEAMCITY_VERSION') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoper006a73f0e455\OndraM\CiDetector\CiDetector::CI_TEAMCITY;
    }
    public function isPullRequest() : \_PhpScoper006a73f0e455\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoper006a73f0e455\OndraM\CiDetector\TrinaryLogic::createMaybe();
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
