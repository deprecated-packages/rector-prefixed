<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\OndraM\CiDetector\Ci;

use _PhpScoperbd5d0c5f7638\OndraM\CiDetector\CiDetector;
use _PhpScoperbd5d0c5f7638\OndraM\CiDetector\Env;
use _PhpScoperbd5d0c5f7638\OndraM\CiDetector\TrinaryLogic;
class BitbucketPipelines extends \_PhpScoperbd5d0c5f7638\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoperbd5d0c5f7638\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('BITBUCKET_COMMIT') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoperbd5d0c5f7638\OndraM\CiDetector\CiDetector::CI_BITBUCKET_PIPELINES;
    }
    public function isPullRequest() : \_PhpScoperbd5d0c5f7638\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoperbd5d0c5f7638\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('BITBUCKET_PR_ID') !== '');
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('BITBUCKET_BUILD_NUMBER');
    }
    public function getBuildUrl() : string
    {
        return \sprintf('%s/addon/pipelines/home#!/results/%s', $this->env->get('BITBUCKET_GIT_HTTP_ORIGIN'), $this->env->get('BITBUCKET_BUILD_NUMBER'));
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('BITBUCKET_COMMIT');
    }
    public function getGitBranch() : string
    {
        return $this->env->getString('BITBUCKET_BRANCH');
    }
    public function getRepositoryName() : string
    {
        return $this->env->getString('BITBUCKET_REPO_FULL_NAME');
    }
    public function getRepositoryUrl() : string
    {
        return \sprintf('ssh://%s', $this->env->get('BITBUCKET_GIT_SSH_ORIGIN'));
    }
}
