<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController 
{
    public function index(): Response
    {
        return new Response(
            '<html><body>Default page</body></html>'
        );
    }
}
