<?php

declare(strict_types=1);

namespace App\Tests\Func;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use App\DataFixtures\AppFixtures;


 abstract class AbstractEndPoint extends WebTestCase{

    protected $serverInformations = ['ACCEPT'=>'application/json','CONTENT_TYPE'=>'application/json'];
    protected $tokenNotFound='JWT Token not found';
    protected $notYourResource='It is not your resource';
    protected $loginPayload='{"email":"%s","password":"%s"}';

    public function getResponseFromRequest(
        string $method, 
        string $uri,
        string $payload='',
        array $parameter = [],
        bool $withAuthentification=true
        ):Response{
       //$client=self::createClient();

       $client=$this->createAuthentificationClient($withAuthentification);
       //Marche bien jusqu'à là

       $client->request(
           $method,
           $uri,
           [],
           $parameter,
           $this->serverInformations,
           $payload
       );
        return $client->getResponse();
    }

    protected function createAuthentificationClient(bool $withAuthentification):KernelBrowser{
        $client=static::createClient();

        if(!$withAuthentification){
            return $client;
        }

        $client->request(
           Request::METHOD_POST,
           '/login_check',
           [''],
           [],
           $this->serverInformations,
           sprintf($this->loginPayload,'sergio_cashier@gmail.com', 'test'));

        // $client->request(
        //     'POST',
        //     '/login_check',
        //     ['email' => 'john_user@gmail.com', 'password' => 'test'],
        //     [],
        //     ['ACCEPT'=>'application/json','CONTENT_TYPE'=>'application/json']
        //  );

           $data = json_decode($client->getResponse()->getContent(),true);
           $client->setServerParameter('HTTP_Authorization',sprintf('Bearer '.$data['token']));
           return $client;
    }
}