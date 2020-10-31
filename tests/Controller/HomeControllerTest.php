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
                "Sign in",
                $crawler->filter('button[type=submit]')
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
        
        $form = $crawler->filter('button[type=submit]')->form();
        $crawler = $client->submit($form, array(
          'password'  => '123456')
        );

        $crawler = $client->followRedirect();
        
        $this->assertSame(
                "Email could not be found.", 
                $crawler->filter('p.alert-danger')
                ->text());
 
    }
    
    /*
     * REQ-PUB-LOG-05
    */
    
    public function testEmptyFieldPasswordLogin() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('button[type=submit]')->form();
        
        $crawler = $client->submit($form, array(
          'email'  => 'admin@admin.es')
        );
        
        $crawler = $client->followRedirect();
        
        $this->assertSame(
                //Debes indicar la contraseña,
                'Invalid credentials.',
                $crawler->filter('p.alert-danger')
                ->text()
        );
    }
    
    /*
     * REQ-PUB-LOG-06
    */
    
    public function testIncorrectDataAccess() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('button[type=submit]')->form();
        
        $crawler = $client->submit($form, array(
            'email' => 'admin@admin.es', 
            'password'  => '111111')
        );
        
        $crawler = $client->followRedirect();
        
        $this->assertSame(
                'Invalid credentials.',
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
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('button[type=submit]')->form();
        
        $crawler = $client->submit($form, array(
            'email' => 'admin@admin.es', 
            'password'  => '123456')
        );
        
        $this->assertResponseRedirects('/dashboard');
    }
    
    /*
     * REQ-PUB-LOG-08
    */
    public function testAdminAccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('button[type=submit]')->form();
        
        $crawler = $client->submit($form, array(
            'email' => 'admin@admin.es', 
            'password'  => '123456')
        );
        
        $crawler = $client->followRedirect();

        $this->assertResponseRedirects('/admin/dashboard');
    }
    
    /*
     * REQ-PUB-LOG-09
    */
    public function testSalesAccess()
    {   
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('button[type=submit]')->form();
        
        $crawler = $client->submit($form, array(
            'email' => 'sales@sales.es', 
            'password'  => '123456')
        );
        
        $crawler = $client->followRedirect();
        
        $this->assertResponseRedirects('/sales/dashboard');
    }
    
    /*
     * REQ-PUB-LOG-10
    */
    public function testChiefProjectAccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('button[type=submit]')->form();
        
        $crawler = $client->submit($form, array(
            'email' => 'chief@chief.es', 
            'password'  => '123456')
        );
        
        $crawler = $client->followRedirect();
        
        $this->assertResponseRedirects('/chief-project/dashboard');
    }
    
    /*
     * REQ-PUB-LOG-11
    */
    public function testTechnicianAccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('button[type=submit]')->form();
        
        $crawler = $client->submit($form, array(
            'email' => 'tech@tech.es', 
            'password'  => '123456')
        );
        
        $crawler = $client->followRedirect();
        
        $this->assertResponseRedirects('/technician/dashboard');
        
    }
    
    public function testClientAccess()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->filter('button[type=submit]')->form();
        
        $crawler = $client->submit($form, array(
            'email' => 'client@client.es', 
            'password'  => '123456')
        );
        
        $crawler = $client->followRedirect();
        
        $this->assertResponseRedirects('/client/dashboard');
    }
}