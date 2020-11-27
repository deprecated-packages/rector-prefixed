<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\OndraM\CiDetector\Ci;

use _PhpScoper26e51eeacccf\OndraM\CiDetector\CiDetector;
use _PhpScoper26e51eeacccf\OndraM\CiDetector\Env;
use _PhpScoper26e51eeacccf\OndraM\CiDetector\TrinaryLogic;
class GitHubActions extends \_PhpScoper26e51eeacccf\OndraM\CiDetector\Ci\AbstractCi
{
    public const GITHUB_BASE_URL = 'https://github.com';
    public static function isDetected(\_PhpScoper26e51eeacccf\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('GITHUB_ACTIONS') !== \false;
    }
    public function getCiName() : string
    {
        return \_PhpScoper26e51eeacccf\OndraM\CiDetector\CiDetector::CI_GITHUB_ACTIONS;
    }
    public function isPullRequest() : \_PhpScoper26e51eeacccf\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoper26e51eeacccf\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('GITHUB_EVENT_NAME') === 'pull_request');
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('GITHUB_RUN_NUMBER');
    }
    public function getBuildUrl() : string
    {
        return \sprintf('%s/%s/commit/%s/checks', self::GITHUB_BASE_URL, $this->env->get('GITHUB_REPOSITORY'), $this->env->get('GITHUB_SHA'));
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('GITHUB_SHA');
    }
    public function getGitBranch() : string
    {
        $prBranch = $this->env->getString('GITHUB_HEAD_REF');
        if ($this->isPullRequest()->no() || empty($prBranch)) {
            $gitReference = $this->env->getString('GITHUB_REF');
            return \preg_replace('~^refs/heads/~', '', $gitReference) ?? '';
        }
        return $prBranch;
    }
    public function getRepositoryName() : string
    {
        return $this->env->getString('GITHUB_REPOSITORY');
    }
    public function getRepositoryUrl() : string
    {
        return \sprintf('%s/%s', self::GITHUB_BASE_URL, $this->env->get('GITHUB_REPOSITORY'));
    }
}
