<?php
namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
*/

class AdminController extends AbstractController
{
    public function dashboard()
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
    }
}