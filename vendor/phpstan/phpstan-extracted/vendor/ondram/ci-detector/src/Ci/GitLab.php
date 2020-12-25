<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector;
use _HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
use _HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic;
class GitLab extends \_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('GITLAB_CI') !== \false;
    }
    public function getCiName() : string
    {
        return \_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector::CI_GITLAB;
    }
    public function isPullRequest() : \_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic
    {
        return \_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->get('CI_MERGE_REQUEST_ID') !== \false || $this->env->get('CI_EXTERNAL_PULL_REQUEST_IID') !== \false);
    }
    public function getBuildNumber() : string
    {
        return !empty($this->env->getString('CI_JOB_ID')) ? $this->env->getString('CI_JOB_ID') : $this->env->getString('CI_BUILD_ID');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('CI_PROJECT_URL') . '/builds/' . $this->getBuildNumber();
    }
    public function getGitCommit() : string
    {
        return !empty($this->env->getString('CI_COMMIT_SHA')) ? $this->env->getString('CI_COMMIT_SHA') : $this->env->getString('CI_BUILD_REF');
    }
    public function getGitBranch() : string
    {
        return !empty($this->env->getString('CI_COMMIT_REF_NAME')) ? $this->env->getString('CI_COMMIT_REF_NAME') : $this->env->getString('CI_BUILD_REF_NAME');
    }
    public function getRepositoryName() : string
    {
        return $this->env->getString('CI_PROJECT_PATH');
    }
    public function getRepositoryUrl() : string
    {
        return !empty($this->env->getString('CI_REPOSITORY_URL')) ? $this->env->getString('CI_REPOSITORY_URL') : $this->env->getString('CI_BUILD_REPO');
    }
}
