<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController 
{
    public function index(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Default page</body></html>'
        );
    }
}
