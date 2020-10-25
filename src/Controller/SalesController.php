<?php

namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/sales")
 */

class SalesController extends AbstractController
{
    
    /**
     * @Route("/dashboard", name="sales_dashboard", methods={"GET","POST"})
     */
    public function dashboard()
    {
        return new Response(
            '<html><body>Sales Dashboard</body></html>'
        );
    }
}