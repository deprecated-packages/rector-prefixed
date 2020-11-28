<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\OndraM\CiDetector\Ci;

use _PhpScoperabd03f0baf05\OndraM\CiDetector\Env;
/**
 * Unified adapter to retrieve environment variables from current continuous integration server
 */
abstract class AbstractCi implements \_PhpScoperabd03f0baf05\OndraM\CiDetector\Ci\CiInterface
{
    /** @var Env */
    protected $env;
    public function __construct(\_PhpScoperabd03f0baf05\OndraM\CiDetector\Env $env)
    {
        $this->env = $env;
    }
}
