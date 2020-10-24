<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * Require ROLE_TECHNICIAN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_TECHNICIAN")
*/

class TechnicianController extends AbstractController
{
    public function dashboard()
    {
        //$this->denyAccessUnlessGranted('ROLE_TECHNICIAN');
    }
}