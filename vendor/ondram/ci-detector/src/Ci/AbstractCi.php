<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\OndraM\CiDetector\Ci;

use _PhpScoper006a73f0e455\OndraM\CiDetector\Env;
/**
 * Unified adapter to retrieve environment variables from current continuous integration server
 */
abstract class AbstractCi implements \_PhpScoper006a73f0e455\OndraM\CiDetector\Ci\CiInterface
{
    /** @var Env */
    protected $env;
    public function __construct(\_PhpScoper006a73f0e455\OndraM\CiDetector\Env $env)
    {
        $this->env = $env;
    }
}
