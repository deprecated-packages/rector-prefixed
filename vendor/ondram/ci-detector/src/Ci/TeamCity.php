<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\OndraM\CiDetector\Ci;

use _PhpScoperbd5d0c5f7638\OndraM\CiDetector\CiDetector;
use _PhpScoperbd5d0c5f7638\OndraM\CiDetector\Env;
use _PhpScoperbd5d0c5f7638\OndraM\CiDetector\TrinaryLogic;
class TeamCity extends \_PhpScoperbd5d0c5f7638\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoperbd5d0c5f7638\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('TEAMCITY_VERSION') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoperbd5d0c5f7638\OndraM\CiDetector\CiDetector::CI_TEAMCITY;
    }
    public function isPullRequest() : \_PhpScoperbd5d0c5f7638\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoperbd5d0c5f7638\OndraM\CiDetector\TrinaryLogic::createMaybe();
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
