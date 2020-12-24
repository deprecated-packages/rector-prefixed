<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic;
class Bamboo extends \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('bamboo_buildKey') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector::CI_BAMBOO;
    }
    public function isPullRequest() : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->get('bamboo_repository_pr_key') !== \false);
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('bamboo_buildNumber');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('bamboo_resultsUrl');
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('bamboo_planRepository_revision');
    }
    public function getGitBranch() : string
    {
        $prBranch = $this->env->getString('bamboo_repository_pr_sourceBranch');
        if ($this->isPullRequest()->no() || empty($prBranch)) {
            return $this->env->getString('bamboo_planRepository_branch');
        }
        return $prBranch;
    }
    public function getRepositoryName() : string
    {
        return $this->env->getString('bamboo_planRepository_name');
    }
    public function getRepositoryUrl() : string
    {
        return $this->env->getString('bamboo_planRepository_repositoryUrl');
    }
}
