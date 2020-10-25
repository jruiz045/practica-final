<?php

namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/client")
 */

class ClientController extends AbstractController
{
    
    /**
     * @Route("/dashboard", name="client_dashboard", methods={"GET","POST"})
     */
    public function dashboard()
    {
        return new Response(
            '<html><body>Client Dashboard</body></html>'
        );
    }
}