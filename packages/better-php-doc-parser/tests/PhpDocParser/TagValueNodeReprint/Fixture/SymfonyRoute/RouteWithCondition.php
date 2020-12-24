<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Routing\Annotation\Route;
final class RouteWithCondition
{
    /**
     * @Route(
     *     path="/remove/{object}/{when}/{slot}",
     *     name="route_name",
     *     requirements={"object"="\d{1,9}", "when"="\d{4}-\d{2}-\d{2}", "slot"="\d{1,9}"},
     *     options={"expose"=true, "i18n"=false},
     *     condition="request.isXmlHttpRequest()"
     * )
     */
    public function run()
    {
    }
}
