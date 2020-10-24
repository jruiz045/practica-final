<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * Require ROLE_CLIENT for *every* controller method in this class.
 *
 * @IsGranted("ROLE_CLIENT")
*/

class ClientController extends AbstractController
{
    public function dashboard()
    {
        //$this->denyAccessUnlessGranted('ROLE_CLIENT');
    }
}