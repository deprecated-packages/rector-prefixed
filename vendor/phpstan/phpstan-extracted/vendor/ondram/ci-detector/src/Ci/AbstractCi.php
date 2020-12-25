<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci;

use _HumbugBox221ad6f1b81f\OndraM\CiDetector\Env;
/**
 * Unified adapter to retrieve environment variables from current continuous integration server
 */
abstract class AbstractCi implements \_HumbugBox221ad6f1b81f\OndraM\CiDetector\Ci\CiInterface
{
    /** @var Env */
    protected $env;
    public function __construct(\_HumbugBox221ad6f1b81f\OndraM\CiDetector\Env $env)
    {
        $this->env = $env;
    }
}
