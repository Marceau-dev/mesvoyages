<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of VoyagesControllerTest
 *
 * @author marce
 */
class VoyagesControllerTest extends WebTestCase{

    public function testAccesPage() {
        $client = static::createClient();
        $client->request('GET','/voyages');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    public function testContenuPage(){
        $client = static::createClient();
        $crawler = $client->request('GET','/voyages');
        $client->request('GET','/voyages');
        $this->assertSelectorTextContains('h1','Mes voyages');
        $this->assertSelectorTextContains('th','Ville');
        $this->assertCount(5,$crawler->filter('th'));
        $this->assertSelectorTextContains('h5','Tharparkar');
    }
    
    public function testLinkVille(){
        $client = static::createClient();
        $client->request('GET','/voyages');
        $client->clickLink("Tharparkar");
        $response = $client->getResponse();
//        A garder cette ligne car c'est interressant.
//        dd($client->getRequest());
        $this->assertEquals(Response::HTTP_OK,$response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/voyages/voyage/99',$uri);
    }
    
    public function testFiltreVille(){
        $client = static::createClient();
        $client->request('GET','/voyages');
        $crawler = $client->submitForm('filtrer', [
                'recherche'=>'Tharparkar'
        ]);
        $this->assertCount(1,$crawler->filter('h5'));
        $this->assertSelectorTextContains('h5','Tharparkar');
    }
}
