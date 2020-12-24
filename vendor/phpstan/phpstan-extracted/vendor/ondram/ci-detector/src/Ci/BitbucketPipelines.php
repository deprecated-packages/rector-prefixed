<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic;
class BitbucketPipelines extends \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('BITBUCKET_COMMIT') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector::CI_BITBUCKET_PIPELINES;
    }
    public function isPullRequest() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('BITBUCKET_PR_ID') !== '');
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
