<?php

namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/chief-project")
 */

class ChiefProjectController extends AbstractController
{
    
    /**
     * @Route("/dashboard", name="chiefproject_dashboard", methods={"GET","POST"})
     */
    public function dashboard()
    {
        return new Response(
            '<html><body>Chief Project Dashboard</body></html>'
        );
    }
}