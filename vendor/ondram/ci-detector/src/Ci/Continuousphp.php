<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\OndraM\CiDetector\Ci;

use _PhpScoperabd03f0baf05\OndraM\CiDetector\CiDetector;
use _PhpScoperabd03f0baf05\OndraM\CiDetector\Env;
use _PhpScoperabd03f0baf05\OndraM\CiDetector\TrinaryLogic;
class Continuousphp extends \_PhpScoperabd03f0baf05\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoperabd03f0baf05\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('CONTINUOUSPHP') === 'continuousphp';
    }
    public function getCiName() : string
    {
        return \_PhpScoperabd03f0baf05\OndraM\CiDetector\CiDetector::CI_CONTINUOUSPHP;
    }
    public function isPullRequest() : \_PhpScoperabd03f0baf05\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoperabd03f0baf05\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('CPHP_PR_ID') !== '');
    }
    public function getBuildNumber() : string
    {
        return $this->env->getString('CPHP_BUILD_ID');
    }
    public function getBuildUrl() : string
    {
        return $this->env->getString('');
    }
    public function getGitCommit() : string
    {
        return $this->env->getString('CPHP_GIT_COMMIT');
    }
    public function getGitBranch() : string
    {
        $gitReference = $this->env->getString('CPHP_GIT_REF');
        return \preg_replace('~^refs/heads/~', '', $gitReference) ?? '';
    }
    public function getRepositoryName() : string
    {
        return '';
        // unsupported
    }
    public function getRepositoryUrl() : string
    {
        return $this->env->getString('');
    }
}
