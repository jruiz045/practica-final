<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 */

class DefaultController extends AbstractController
{
    
    /**
     * @Route("/", name="default_homepage", methods={"GET"})
     */
    public function homepage(): Response
    {
        return new Response(
            '<html><body>Homepage</body></html>'
        );
    }
    
    /**
     * @Route("/dashboard", name="dashboard")
    */
    
    public function dashboard() 
    {
        
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_dashboard');
        } else if($this->isGranted('ROLE_SALES')) {
            return $this->redirectToRoute('sales_dashboard');
        } else if($this->isGranted('ROLE_CHIEF_PROJECT')) {
            return $this->redirectToRoute('chiefproject_dashboard');
        } else if($this->isGranted('ROLE_TECHNICIAN')) {
            return $this->redirectToRoute('technician_dashboard');
        } else if($this->isGranted('ROLE_CLIENT')) {
            return $this->redirectToRoute('client_dashboard');
        } else {
            return $this->redirectToRoute('default_homepage');
        }
        
    }
}
