<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\OndraM\CiDetector\Ci;

use _PhpScoper88fe6e0ad041\OndraM\CiDetector\CiDetector;
use _PhpScoper88fe6e0ad041\OndraM\CiDetector\Env;
use _PhpScoper88fe6e0ad041\OndraM\CiDetector\TrinaryLogic;
class Wercker extends \_PhpScoper88fe6e0ad041\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoper88fe6e0ad041\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('WERCKER') === 'true';
    }
    public function getCiName() : string
    {
        return \_PhpScoper88fe6e0ad041\OndraM\CiDetector\CiDetector::CI_WERCKER;
    }
    public function isPullRequest() : \_PhpScoper88fe6e0ad041\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoper88fe6e0ad041\OndraM\CiDetector\TrinaryLogic::createMaybe();
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('WERCKER_RUN_ID');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('WERCKER_RUN_URL');
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('WERCKER_GIT_COMMIT');
    }
    public function getGitBranch() : string
    {
        return $this->env->getString('WERCKER_GIT_BRANCH');
    }
    public function getRepositoryName() : string
    {
        return $this->env->getString('WERCKER_GIT_OWNER') . '/' . $this->env->getString('WERCKER_GIT_REPOSITORY');
    }
    public function getRepositoryUrl() : string
    {
        return '';
        // unsupported
    }
}
