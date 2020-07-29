<?php

declare(strict_types=1);

namespace App\Tests\Func;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketTest extends AbstractEndPoint{

    public function testGetTickets():array{

        $response=$this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/fatboar/tickets'.'.json',
            '',
             [],
             true
        );
        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent,true);
        
        self::assertEquals(Response::HTTP_OK,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
        // self::assertNotSame($es[0],$responseDecoded);
        // self::assertContains("user",$responseContent);

        return $responseDecoded;
    }

    public function testPostTickets():void{

        $unTicket='{	
            "numoticket":222222,
            "datepublished":"2020-02-06",
            "totalprice":54,
            "etat":"DISPONIBLE",
            "ticketlot":"/api/fatboar/lots/2"
        }';
        $response=$this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/fatboar/tickets'.'.json',
            $unTicket,
             [],
             true
        );
        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent,true);
        
        self::assertEquals(Response::HTTP_CREATED,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
        // self::assertNotSame($es[0],$responseDecoded);
        // self::assertContains("user",$responseContent);
    }

    public function testPutTickets():void{

        $id=rand(1,4);
        
        $NewEtat='{	
            "etat":"NEW MAJ ADMIN"
        }';
        $response=$this->getResponseFromRequest(
            Request::METHOD_PUT,
            '/api/fatboar/tickets/'.$id.'.json',
            $NewEtat,
             [],
             true
        );
        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent,true);
        
        self::assertEquals(Response::HTTP_OK,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
        // self::assertNotSame($es[0],$responseDecoded);
        // self::assertContains("user",$responseContent);
    }

    public function testDeleteTickets():void{
        $id=rand(1,4);
       
        $response=$this->getResponseFromRequest(
            Request::METHOD_DELETE,
            '/api/fatboar/tickets/'.$id.'.json',
            '',
             [],
             true
        );
        $responseContent=$response->getContent();
        
        self::assertEquals(Response::HTTP_NO_CONTENT,$response->getStatusCode());
        // self::assertNotSame($es[0],$responseDecoded);
        // self::assertContains("user",$responseContent);
    }

}
