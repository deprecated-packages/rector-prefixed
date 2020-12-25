<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper50d83356d739\Symfony\Contracts\HttpClient;

/**
 * Yields response chunks, returned by HttpClientInterface::stream().
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
interface ResponseStreamInterface extends \Iterator
{
    public function key() : \_PhpScoper50d83356d739\Symfony\Contracts\HttpClient\ResponseInterface;
    public function current() : \_PhpScoper50d83356d739\Symfony\Contracts\HttpClient\ChunkInterface;
}
