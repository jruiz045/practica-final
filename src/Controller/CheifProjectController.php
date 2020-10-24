<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * Require ROLE_CHIEF_PROJECT for *every* controller method in this class.
 *
 * @IsGranted("ROLE_CHIEF_PROJECT")
*/

class ChiefProjectController extends AbstractController
{
    public function dashboard()
    {
        //$this->denyAccessUnlessGranted('ROLE_CHIEF_PROJECT');
    }
}