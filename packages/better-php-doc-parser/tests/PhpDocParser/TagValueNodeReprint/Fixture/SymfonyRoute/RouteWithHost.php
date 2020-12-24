<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScoper0a6b37af0871\Symfony\Component\Routing\Annotation\Route;
final class RouteWithHost
{
    /**
     * @Route("/user", name="user_index", host="%test%", methods={"GET"})
     */
    public function run()
    {
    }
}
