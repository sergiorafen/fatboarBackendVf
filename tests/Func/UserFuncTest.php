<?php

declare(strict_types=1);

namespace App\Tests\Func;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;
use App\DataFixtures\AppFixtures;

class UserFuncTest extends AbstractEndPoint{

    // private string $userPayload='{"email":"%s","password":"password"}';

    public function testGetUsers():void{

        $response=$this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/fatboar/users',
            $this->getPayLoad(),
            [],
        false);

        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testPostUsers():void{

        $response=$this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/fatboar/users',
            $this->getPayLoad(),
            [],false
        );
        

        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent);

        self::assertEquals(Response::HTTP_CREATED,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testGetDefaultUser():int{
        $response=$this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/fatboar/users',
            '',
             ['email'=>AppFixtures::DEFAULT_USER['email']],
             false
        );

        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent,true);

        self::assertEquals(Response::HTTP_OK,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);

        return $responseDecoded[0]['id'];
    }

    /**
     * @depends testGetDefaultUser
    */
    public function testPutdDefaultUsers(int $id):void{

        $response=$this->getResponseFromRequest(
            Request::METHOD_PUT,
            '/api/fatboar/users'.$id,
            $this->getPayLoad(),
            [],false
        );

        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent);

        self::assertEquals(Response::HTTP_UNAUTHORIZED,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    // public function testPatchDefaultUsers(int $id):void{

    //     $response=$this->getResponseFromRequest(
    //         Request::METHOD_PATCH,
    //         '/api/fatboar/users'.$id,
    //         $this->getPayLoad(),
    //         [],false
    //     );

    //     $responseContent=$response->getContent();
    //     $responseDecoded=json_decode($responseContent);

    //     self::assertEquals(Response::HTTP_UNAUTHORIZED,$response->getStatusCode());
    //     self::assertJson($responseContent);
    //     self::assertNotEmpty($responseDecoded);
    // }

    /**
     * @depends testGetDefaultUser
    */
    public function testDeleteDefaultUsers(int $id):void{

        $response=$this->getResponseFromRequest(
            Request::METHOD_DELETE,
            '/api/fatboar/users'.$id,
            $this->getPayLoad(),
            [],false
        );

        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent,true);

        self::assertEquals(Response::HTTP_UNAUTHORIZED,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
        self::assertEquals($this->notYourResource,$responseDecoded['detail']);
    }

     /**
     * @depends testPostUsers
    */
    public function testDeleteOtherUSerWithJWT(int $id):void{

        $response=$this->getResponseFromRequest(
            Request::METHOD_DELETE,
            '/api/fatboar/users'.$id
        );

        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent,true);

        self::assertEquals(Response::HTTP_UNAUTHORIZED,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
        self::assertEquals($this->notYourResource,$responseDecoded['detail']);
    }

       /**
     * @depends testGetDefaultUser
    */
    public function testDeleteDefaultUserWithJWT(int $id):void{

        $response=$this->getResponseFromRequest(
            Request::METHOD_DELETE,
            '/api/fatboar/users'.$id
        );

        $responseContent=$response->getContent();

        self::assertEquals(Response::HTTP_NO_CONTENT,$response->getStatusCode());
    }

    public function testPostDefaultUsers():void{

        $response=$this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/fatboar/users',
            json_encode(AppFixtures::DEFAULT_USER),
            [],
            false
        );

        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent);

        self::assertEquals(Response::HTTP_CREATED,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testPostSameDefaultUsers():void{

        $response=$this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/fatboar/users',
            json_encode(AppFixtures::DEFAULT_USER),
            [],
            false
        );

        $responseContent=$response->getContent();
        $responseDecoded=json_decode($responseContent);

        self::assertEquals(Response::HTTP_BAD_REQUEST,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    private function getPayLoad():string{
        $userPayload='{"email":"%s","password":"password"}';
        $faker=Factory::create();
        return sprintf($userPayload,$faker->email);
    }
}