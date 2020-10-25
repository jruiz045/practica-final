<?php
namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="admin_dashboard", methods={"GET","POST"})
     */
    public function dashboard()
    {
        //$this->denyAccessUnlessGranted('ADMIN');
        return new Response(
            '<html><body>Admin Dashboard</body></html>'
        );
    }
}