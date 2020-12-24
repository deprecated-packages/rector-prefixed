<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
/**
 * Unified adapter to retrieve environment variables from current continuous integration server
 */
abstract class AbstractCi implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\CiInterface
{
    /** @var Env */
    protected $env;
    public function __construct(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env)
    {
        $this->env = $env;
    }
}
