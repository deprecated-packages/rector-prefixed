<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\OndraM\CiDetector\Ci;

use _PhpScoper006a73f0e455\OndraM\CiDetector\CiDetector;
use _PhpScoper006a73f0e455\OndraM\CiDetector\Env;
use _PhpScoper006a73f0e455\OndraM\CiDetector\TrinaryLogic;
class AppVeyor extends \_PhpScoper006a73f0e455\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoper006a73f0e455\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('APPVEYOR') === 'True';
    }
    public function getCiName() : string
    {
        return \_PhpScoper006a73f0e455\OndraM\CiDetector\CiDetector::CI_APPVEYOR;
    }
    public function isPullRequest() : \_PhpScoper006a73f0e455\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoper006a73f0e455\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('APPVEYOR_PULL_REQUEST_NUMBER') !== '');
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('APPVEYOR_BUILD_NUMBER');
    }
    public function getBuildUrl() : string
    {
        return \sprintf('%s/project/%s/%s/builds/%s', $this->env->get('APPVEYOR_URL'), $this->env->get('APPVEYOR_ACCOUNT_NAME'), $this->env->get('APPVEYOR_PROJECT_SLUG'), $this->env->get('APPVEYOR_BUILD_ID'));
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('APPVEYOR_REPO_COMMIT');
    }
    public function getGitBranch() : string
    {
        $prBranch = $this->env->getString('APPVEYOR_PULL_REQUEST_HEAD_REPO_BRANCH');
        if ($this->isPullRequest()->no() || empty($prBranch)) {
            return $this->env->getString('APPVEYOR_REPO_BRANCH');
        }
        return $prBranch;
    }
    public function getRepositoryName() : string
    {
        return $this->env->getString('APPVEYOR_REPO_NAME');
    }
    public function getRepositoryUrl() : string
    {
        return '';
        // unsupported
    }
}
