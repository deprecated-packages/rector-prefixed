<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic;
class AwsCodeBuild extends \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('CODEBUILD_CI') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector::CI_AWS_CODEBUILD;
    }
    public function isPullRequest() : \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic::createFromBoolean(\mb_strpos($this->env->getString('CODEBUILD_WEBHOOK_EVENT'), 'PULL_REQUEST') === 0);
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
