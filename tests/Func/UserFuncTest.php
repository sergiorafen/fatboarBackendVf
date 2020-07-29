<?php

declare(strict_types=1);

namespace App\Tests\Func;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserFuncTest extends AbstractEndPoint{
    
    // protected $serverInformations = ['ACCEPT'=>'application/json','CONTENT_TYPE'=>'application/json'];
    // protected $tokenNotFound='JWT Token not found';
    // protected $notYourResource='It is not your resource';
    
    // protected $sampleUser='{	
    //     "username":"Babou",
    //     "email":"test@gmail.com",
    //     "password":"1234",
    //     "cgvcgu":true,
    //     "newsletter":true,
    //     "majeur":true,
    //     "roles":["ROLE_USER"]
    // }';

    // public function testRegister():KernelBrowser{

    //     $client=static::createClient();



    //     $client->request(
    //         Request::METHOD_POST,
    //         '/register',
    //          [''],
    //          [],
    //          $this->serverInformations,
    //          sprintf($this->sampleUser));

    //     $response=$client->getResponse();
    //     $responseContent=$response->getContent();
    //     $responseDecoded=json_decode($responseContent,true);
        
    //     self::assertEquals(Response::HTTP_OK,$response->getStatusCode());
    //     self::assertJson($responseContent);
    //     self::assertNotEmpty($responseDecoded);
    //     // self::assertNotSame($es[0],$responseDecoded);
    //     // self::assertContains("user",$responseContent);
    //     return $client;
    // }

    public function testGetUserInfo():array{

        $response=$this->getResponseFromRequest(
            Request::METHOD_GET,
            '/apitest',
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

    // public function testManageCashier():void{

    //     $unTicket='{	
    //         "numoticket":222222,
    //         "datepublished":"2020-02-06",
    //         "totalprice":54,
    //         "etat":"DISPONIBLE",
    //         "ticketlot":"/api/fatboar/lots/2"
    //     }';
    //     $response=$this->getResponseFromRequest(
    //         Request::METHOD_POST,
    //         '/api/fatboar/admin',
    //         $unTicket,
    //          [],
    //          true
    //     );
    //     $responseContent=$response->getContent();
    //     $responseDecoded=json_decode($responseContent,true);
        
    //     self::assertEquals(Response::HTTP_CREATED,$response->getStatusCode());
    //     self::assertJson($responseContent);
    //     self::assertNotEmpty($responseDecoded);
    //     // self::assertNotSame($es[0],$responseDecoded);
    //     // self::assertContains("user",$responseContent);
    // }
}
