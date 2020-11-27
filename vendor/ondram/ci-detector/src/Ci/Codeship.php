<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\OndraM\CiDetector\Ci;

use _PhpScopera143bcca66cb\OndraM\CiDetector\CiDetector;
use _PhpScopera143bcca66cb\OndraM\CiDetector\Env;
use _PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic;
class Codeship extends \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScopera143bcca66cb\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('CI_NAME') === 'codeship';
    }
    public function getCiName() : string
    {
        return \_PhpScopera143bcca66cb\OndraM\CiDetector\CiDetector::CI_CODESHIP;
    }
    public function isPullRequest() : \_PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('CI_PULL_REQUEST') !== 'false');
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('CI_BUILD_NUMBER');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('CI_BUILD_URL');
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('COMMIT_ID');
    }
    public function getGitBranch() : string
    {
        return $this->env->getString('CI_BRANCH');
    }
    public function getRepositoryName() : string
    {
        return $this->env->getString('CI_REPO_NAME');
    }
    public function getRepositoryUrl() : string
    {
        return '';
        // unsupported
    }
}
