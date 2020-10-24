<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * Require ROLE_SALES for *every* controller method in this class.
 *
 * @IsGranted("ROLE_SALES")
*/

class SalesController extends AbstractController
{
    public function dashboard()
    {
        //$this->denyAccessUnlessGranted('ROLE_SALES');
    }
}