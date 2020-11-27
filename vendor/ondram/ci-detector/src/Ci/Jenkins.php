<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\OndraM\CiDetector\Ci;

use _PhpScopera143bcca66cb\OndraM\CiDetector\CiDetector;
use _PhpScopera143bcca66cb\OndraM\CiDetector\Env;
use _PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic;
class Jenkins extends \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScopera143bcca66cb\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('JENKINS_URL') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScopera143bcca66cb\OndraM\CiDetector\CiDetector::CI_JENKINS;
    }
    public function isPullRequest() : \_PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic::createMaybe();
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('BUILD_NUMBER');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('BUILD_URL');
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('GIT_COMMIT');
    }
    public function getGitBranch() : string
    {
        return $this->env->getString('GIT_BRANCH');
    }
    public function getRepositoryName() : string
    {
        return '';
        // unsupported
    }
    public function getRepositoryUrl() : string
    {
        return $this->env->getString('GIT_URL');
    }
}
