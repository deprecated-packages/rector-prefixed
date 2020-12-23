<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic;
class Wercker extends \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\AbstractCi
{
    public static function isDetected(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env) : bool
    {
        return $env->get('WERCKER') === 'true';
    }
    public function getCiName() : string
    {
        return \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\CiDetector::CI_WERCKER;
    }
    public function isPullRequest() : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\OndraM\CiDetector\TrinaryLogic::createMaybe();
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
