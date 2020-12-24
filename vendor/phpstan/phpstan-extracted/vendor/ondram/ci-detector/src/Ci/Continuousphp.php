<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic;
class Continuousphp extends \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('CONTINUOUSPHP') === 'continuousphp';
    }
    public function getCiName() : string
    {
        return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector::CI_CONTINUOUSPHP;
    }
    public function isPullRequest() : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic::createFromBoolean($this->env->getString('CPHP_PR_ID') !== '');
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
