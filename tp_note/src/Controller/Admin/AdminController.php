<?php 

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    #[Route(path: '/user-profile', name: 'user_page')]
    public function userProfile(): Response
    {
        return $this->render('auth/user_profile.html.twig');
    }

    #[Route(path: '/admin', name: 'admin_index')]
    public function adminIndex(): Response
    {
        return $this->render('auth/admin_index.html.twig');
    }
}