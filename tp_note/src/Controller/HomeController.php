<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // public function __construct(
    //     Request $request,
    //     protected LoggerInterface $logger,
    //     protected Filesystem $filesystem,
    // )
    // {
    // }

    #[Route(path: '/', name: 'page_homepage')]
    public function home()
    {
        return $this->render(view: 'index.html.twig');
    }
}
