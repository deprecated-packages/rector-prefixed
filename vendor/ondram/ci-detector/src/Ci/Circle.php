<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\OndraM\CiDetector\Ci;

use _PhpScoper88fe6e0ad041\OndraM\CiDetector\CiDetector;
use _PhpScoper88fe6e0ad041\OndraM\CiDetector\Env;
use _PhpScoper88fe6e0ad041\OndraM\CiDetector\TrinaryLogic;
class Circle extends \_PhpScoper88fe6e0ad041\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoper88fe6e0ad041\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('CIRCLECI') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoper88fe6e0ad041\OndraM\CiDetector\CiDetector::CI_CIRCLE;
    }
    public function isPullRequest() : \_PhpScoper88fe6e0ad041\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoper88fe6e0ad041\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('CI_PULL_REQUEST') !== '');
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('CIRCLE_BUILD_NUM');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('CIRCLE_BUILD_URL');
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('CIRCLE_SHA1');
    }
    public function getGitBranch() : string
    {
        return $this->env->getString('CIRCLE_BRANCH');
    }
    public function getRepositoryName() : string
    {
        return \sprintf('%s/%s', $this->env->getString('CIRCLE_PROJECT_USERNAME'), $this->env->getString('CIRCLE_PROJECT_REPONAME'));
    }
    public function getRepositoryUrl() : string
    {
        return $this->env->getString('CIRCLE_REPOSITORY_URL');
    }
}
