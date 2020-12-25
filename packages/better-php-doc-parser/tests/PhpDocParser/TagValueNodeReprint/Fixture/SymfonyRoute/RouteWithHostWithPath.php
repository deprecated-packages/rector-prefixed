<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScoper8b9c402c5f32\Symfony\Component\Routing\Annotation\Route;
final class RouteWithHostWithPath
{
    /**
     * @Route(path="/user", name="user_index", host="%test%", methods={"GET"})
     */
    public function run()
    {
    }
}
