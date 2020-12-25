<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper50d83356d739\Symfony\Component\HttpFoundation\RateLimiter;

use _PhpScoper50d83356d739\Symfony\Component\HttpFoundation\Request;
use _PhpScoper50d83356d739\Symfony\Component\RateLimiter\LimiterInterface;
use _PhpScoper50d83356d739\Symfony\Component\RateLimiter\Policy\NoLimiter;
use _PhpScoper50d83356d739\Symfony\Component\RateLimiter\RateLimit;
/**
 * An implementation of RequestRateLimiterInterface that
 * fits most use-cases.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 *
 * @experimental in 5.2
 */
abstract class AbstractRequestRateLimiter implements \_PhpScoper50d83356d739\Symfony\Component\HttpFoundation\RateLimiter\RequestRateLimiterInterface
{
    public function consume(\_PhpScoper50d83356d739\Symfony\Component\HttpFoundation\Request $request) : \_PhpScoper50d83356d739\Symfony\Component\RateLimiter\RateLimit
    {
        $limiters = $this->getLimiters($request);
        if (0 === \count($limiters)) {
            $limiters = [new \_PhpScoper50d83356d739\Symfony\Component\RateLimiter\Policy\NoLimiter()];
        }
        $minimalRateLimit = null;
        foreach ($limiters as $limiter) {
            $rateLimit = $limiter->consume(1);
            if (null === $minimalRateLimit || $rateLimit->getRemainingTokens() < $minimalRateLimit->getRemainingTokens()) {
                $minimalRateLimit = $rateLimit;
            }
        }
        return $minimalRateLimit;
    }
    public function reset(\_PhpScoper50d83356d739\Symfony\Component\HttpFoundation\Request $request) : void
    {
        foreach ($this->getLimiters($request) as $limiter) {
            $limiter->reset();
        }
    }
    /**
     * @return LimiterInterface[] a set of limiters using keys extracted from the request
     */
    protected abstract function getLimiters(\_PhpScoper50d83356d739\Symfony\Component\HttpFoundation\Request $request) : array;
}
