<?php 

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route(path: '/admin', name: 'page_admin')]
    public function admin()
    {
        return $this->render(view: 'admin/admin.html.twig');
    }

    #[Route(path: '/admin/users', name: 'page_admin_users')]
    public function users()
    {
        return $this->render(view: 'admin/admin_users.html.twig');
    }
}