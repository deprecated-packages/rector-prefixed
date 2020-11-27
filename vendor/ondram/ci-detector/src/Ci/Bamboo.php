<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\OndraM\CiDetector\Ci;

use _PhpScopera143bcca66cb\OndraM\CiDetector\CiDetector;
use _PhpScopera143bcca66cb\OndraM\CiDetector\Env;
use _PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic;
class Bamboo extends \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScopera143bcca66cb\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('bamboo_buildKey') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScopera143bcca66cb\OndraM\CiDetector\CiDetector::CI_BAMBOO;
    }
    public function isPullRequest() : \_PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->get('bamboo_repository_pr_key') !== \false);
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
