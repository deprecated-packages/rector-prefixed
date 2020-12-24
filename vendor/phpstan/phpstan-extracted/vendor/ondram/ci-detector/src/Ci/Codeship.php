<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic;
class Codeship extends \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('CI_NAME') === 'codeship';
    }
    public function getCiName() : string
    {
        return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector::CI_CODESHIP;
    }
    public function isPullRequest() : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('CI_PULL_REQUEST') !== 'false');
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
