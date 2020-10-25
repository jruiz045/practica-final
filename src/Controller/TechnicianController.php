<?php

namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/technician")
 */

class TechnicianController extends AbstractController
{
    
    /**
     * @Route("/dashboard", name="technician_dashboard", methods={"GET","POST"})
     */
    public function dashboard()
    {
        return new Response(
            '<html><body>Yech Dashboard</body></html>'
        );
    }
}