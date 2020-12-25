<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper8b9c402c5f32\Symfony\Component\HttpFoundation\Test\Constraint;

use _PhpScoper8b9c402c5f32\PHPUnit\Framework\Constraint\Constraint;
use _PhpScoper8b9c402c5f32\Symfony\Component\HttpFoundation\Response;
final class ResponseHasHeader extends \_PhpScoper8b9c402c5f32\PHPUnit\Framework\Constraint\Constraint
{
    private $headerName;
    public function __construct(string $headerName)
    {
        $this->headerName = $headerName;
    }
    /**
     * {@inheritdoc}
     */
    public function toString() : string
    {
        return \sprintf('has header "%s"', $this->headerName);
    }
    /**
     * @param Response $response
     *
     * {@inheritdoc}
     */
    protected function matches($response) : bool
    {
        return $response->headers->has($this->headerName);
    }
    /**
     * @param Response $response
     *
     * {@inheritdoc}
     */
    protected function failureDescription($response) : string
    {
        return 'the Response ' . $this->toString();
    }
}
