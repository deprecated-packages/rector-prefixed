<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\OndraM\CiDetector\Ci;

use _PhpScoper88fe6e0ad041\OndraM\CiDetector\Env;
/**
 * Unified adapter to retrieve environment variables from current continuous integration server
 */
abstract class AbstractCi implements \_PhpScoper88fe6e0ad041\OndraM\CiDetector\Ci\CiInterface
{
    /** @var Env */
    protected $env;
    public function __construct(\_PhpScoper88fe6e0ad041\OndraM\CiDetector\Env $env)
    {
        $this->env = $env;
    }
}
