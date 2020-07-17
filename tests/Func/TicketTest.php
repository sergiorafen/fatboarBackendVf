<?php

declare(strict_types=1);

namespace App\Tests\Func;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketTest extends AbstractEndPoint{

    public function testTickets():array{

        $response=$this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/fatboar/tickets',
            '',
             [],
             false
        );

        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent,true);
        
        self::assertEquals(Response::HTTP_OK,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
        self::assertNotSame($es[0],$responseDecoded);
        self::assertContains("author",$responseContent);
    }

}
