<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic;
class Buddy extends \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('BUDDY') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector::CI_BUDDY;
    }
    public function isPullRequest() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('BUDDY_EXECUTION_PULL_REQUEST_ID') !== '');
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('BUDDY_EXECUTION_ID');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('BUDDY_EXECUTION_URL');
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('BUDDY_EXECUTION_REVISION');
    }
    public function getGitBranch() : string
    {
        $prBranch = $this->env->getString('BUDDY_EXECUTION_PULL_REQUEST_HEAD_BRANCH');
        if ($this->isPullRequest()->no() || empty($prBranch)) {
            return $this->env->getString('BUDDY_EXECUTION_BRANCH');
        }
        return $prBranch;
    }
    public function getRepositoryName() : string
    {
        return $this->env->getString('BUDDY_REPO_SLUG');
    }
    public function getRepositoryUrl() : string
    {
        return $this->env->getString('BUDDY_SCM_URL');
    }
}
