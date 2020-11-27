<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\OndraM\CiDetector\Ci;

use _PhpScoperbd5d0c5f7638\OndraM\CiDetector\Env;
/**
 * Unified adapter to retrieve environment variables from current continuous integration server
 */
abstract class AbstractCi implements \_PhpScoperbd5d0c5f7638\OndraM\CiDetector\Ci\CiInterface
{
    /** @var Env */
    protected $env;
    public function __construct(\_PhpScoperbd5d0c5f7638\OndraM\CiDetector\Env $env)
    {
        $this->env = $env;
    }
}
