<?php

namespace Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\Fixture;

use Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Entity\Post;
use Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController;
use _PhpScoper17db12703726\Symfony\Component\HttpFoundation\Response;
final class PostController extends \Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController
{
    public function anythingAction(int $id) : \_PhpScoper17db12703726\Symfony\Component\HttpFoundation\Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Entity\Post::class)->findSomething($id);
        return new \_PhpScoper17db12703726\Symfony\Component\HttpFoundation\Response();
    }
}
?>
-----
<?php 
namespace Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\Fixture;

use Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Entity\Post;
use Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController;
use _PhpScoper17db12703726\Symfony\Component\HttpFoundation\Response;
final class PostController extends \Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\SymfonyController
{
    /**
     * @var \Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Repository\PostRepository
     */
    private $postRepository;
    public function __construct(\Rector\Core\Tests\Rector\Architecture\DoctrineRepositoryAsService\Source\Repository\PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function anythingAction(int $id) : \_PhpScoper17db12703726\Symfony\Component\HttpFoundation\Response
    {
        $em = $this->getDoctrine()->getManager();
        $this->postRepository->findSomething($id);
        return new \_PhpScoper17db12703726\Symfony\Component\HttpFoundation\Response();
    }
}
