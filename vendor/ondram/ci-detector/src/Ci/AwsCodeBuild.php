<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\OndraM\CiDetector\Ci;

use _PhpScopera143bcca66cb\OndraM\CiDetector\CiDetector;
use _PhpScopera143bcca66cb\OndraM\CiDetector\Env;
use _PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic;
class AwsCodeBuild extends \_PhpScopera143bcca66cb\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScopera143bcca66cb\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('CODEBUILD_CI') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScopera143bcca66cb\OndraM\CiDetector\CiDetector::CI_AWS_CODEBUILD;
    }
    public function isPullRequest() : \_PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScopera143bcca66cb\OndraM\CiDetector\TrinaryLogic::createFromBoolean(\mb_strpos($this->env->getString('CODEBUILD_WEBHOOK_EVENT'), 'PULL_REQUEST') === 0);
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('CODEBUILD_BUILD_NUMBER');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('CODEBUILD_BUILD_URL');
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('CODEBUILD_RESOLVED_SOURCE_VERSION');
    }
    public function getGitBranch() : string
    {
        $gitReference = $this->env->getString('CODEBUILD_WEBHOOK_HEAD_REF');
        return \preg_replace('~^refs/heads/~', '', $gitReference) ?? '';
    }
    public function getRepositoryName() : string
    {
        return '';
        // unsupported
    }
    public function getRepositoryUrl() : string
    {
        return $this->env->getString('CODEBUILD_SOURCE_REPO_URL');
    }
}
