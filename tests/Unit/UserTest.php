<?php 

declare(strict_types=1);
namespace App\Tests\Unit;
use App\Entity\User;
use App\Entity\Ticket;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected function setUp():void{

        parent::setUp();
        $this->user=new User();
    }

    public function testGetEmail():void{

        $value='sergio@gmail.com';

        $response=$this->user->setEmail($value);

        self::assertInstanceOf(User::class,$response);
        self::assertEquals($value,$this->user->getEmail());
    }

    // public function testGetRoles():void{

    //     $value = ["ROLE_ADMIN"];

    //     $response=$this->user->setRoles($value);

    //     self::assertInstanceOf(User::class,$response);
    //     self::assertContains("ROLE_ADMIN",$this->user->getRoles());
    // }

    public function testGetPassword():void{

        $value = 'password';

        $response=$this->user->setPassword($value);

        self::assertInstanceOf(User::class,$response);
        self::assertContains($value,$this->user->getPassword());
    }

    public function testGetTicket():void{

        $value = new Ticket();

        $response=$this->user->addTicket($value);

        self::assertInstanceOf(User::class,$response);
        self::assertCount(1,$this->user->getTicket());
        self::assertTrue($this->user->getTicket()->contains($value));

        $response=$this->user->removeTicket($value);

        self::assertInstanceOf(User::class,$response);
        self::assertCount(0,$this->user->getTicket());
        self::assertFalse($this->user->getTicket()->contains($value));
    }
}