<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase 
{
    /*
     * REQ-PUB-LOG-01
    */
    public function testFieldMailExistsLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $this->assertGreaterThan(
                0,
                $crawler->filter('input[type=email]')
                ->first()
                ->count()
        );
    }
    
    /*
     * REQ-PUB-LOG-02
    */
    public function testFieldPasswordExistsLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $this->assertGreaterThan(
                0,
                $crawler->filter('input[type=password]')
                ->first()
                ->count()
        );
    }
    
    /*
     * REQ-PUB-LOG-03
    */
    public function testFIeldEnterExistsLogin() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $this->assertSame(
                'Sign in',
                $crawler->filter('input[type=submit]')
                ->text()
        );
    }
    
    /*
     * REQ-PUB-LOG-04
    */
    
    public function testEmptyFieldMailLogin() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('input[type=submit]')->form();
        
        $client->submit($form, array(
            'email' => '', 
            'password'  => '123456')
        );
        
        $this->assertSame(
                //'Debes indicar el correo',
                'Email could not be found.',
                $crawler->filter('.alert-danger')
                ->text()
        );
    }
    
    /*
     * REQ-PUB-LOG-05
    */
    
    public function testEmptyFieldPasswordLogin() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('input[type=submit]')->form();
        
        $client->submit($form, array(
            'email' => 'john@doe.es', 
            'password'  => '')
        );
        
        $this->assertSame(
                //Debes indicar la contraseña,
                'Credenciales no válidas.',
                $crawler->filter('.alert-danger')
                ->text()
        );
    }
    
    /*
     * REQ-PUB-LOG-06
    */
    
    public function testIncorrectDataAcess() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('input[type=submit]')->form();
        
        $client->submit($form, array(
            'email' => 'john@doe.es', 
            'password'  => '111111')
        );
        
        $this->assertSame(
                //Debes indicar la contraseña,
                'Credenciales no válidas.',
                $crawler->filter('.alert-danger')
                ->text()
        );
    }
    
    /*
     * REQ-PUB-LOG-07
    */
    
    public function testcorrectDataAccess() 
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.es');

        $client->loginUser($testUser);

        $client->request('GET', '/dashboard');
        $this->assertResponseIsSuccessful();
    }
    
    /*
     * REQ-PUB-LOG-08
    */
    public function testAdminAcess()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.es');

        $client->loginUser($testUser);

        $client->request('GET', '/admin/dashboard');
        $this->assertResponseIsSuccessful();
    }
    
    /*
     * REQ-PUB-LOG-09
    */
    public function testSalesAcces()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sales@sales.es');

        $client->loginUser($testUser);

        $client->request('GET', '/sales/dashboard');
        $this->assertResponseIsSuccessful();
    }
    
    /*
     * REQ-PUB-LOG-10
    */
    public function testChiefProjectAccess()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('chief@chief.es');

        $client->loginUser($testUser);

        $client->request('GET', '/chief-project/dashboard');
        $this->assertResponseIsSuccessful();
    }
    
    /*
     * REQ-PUB-LOG-11a
    */
    public function testTechnicianAccess()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('techf@tech.es');

        $client->loginUser($testUser);

        // user is now logged in, so you can test protected resources
        $client->request('GET', '/technical/dashboard');
        $this->assertResponseIsSuccessful();
    }
    
    /*
     * REQ-PUB-LOG-11b
    */
    public function testClientAccess()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('clientf@client.es');

        $client->loginUser($testUser);

        $client->request('GET', '/client/dashboard');
        $this->assertResponseIsSuccessful();
    }
}