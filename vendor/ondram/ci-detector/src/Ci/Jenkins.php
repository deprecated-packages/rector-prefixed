<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\OndraM\CiDetector\Ci;

use _PhpScoper26e51eeacccf\OndraM\CiDetector\CiDetector;
use _PhpScoper26e51eeacccf\OndraM\CiDetector\Env;
use _PhpScoper26e51eeacccf\OndraM\CiDetector\TrinaryLogic;
class Jenkins extends \_PhpScoper26e51eeacccf\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoper26e51eeacccf\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('JENKINS_URL') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoper26e51eeacccf\OndraM\CiDetector\CiDetector::CI_JENKINS;
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
