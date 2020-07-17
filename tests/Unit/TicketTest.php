<?php

declare(strict_types=1);
namespace App\Tests\Unit;
use App\Entity\User;
use App\Entity\Ticket;
use App\Entity\Lot;
use PHPUnit\Framework\TestCase;

class TicketTest extends TestCase
{
    protected function setUp():void{

        parent::setUp();
        $this->ticket=new Ticket();
    }

    public function testGetNumoTicket():void{

        $value=12124;

        $response=$this->ticket->setNumoticket($value);

        self::assertInstanceOf(Ticket::class,$response);
        self::assertEquals($value,$this->ticket->getNumoticket());
    }

    public function testGetDatepublished():void{

        $value=new \DateTime('@'.strtotime('now'));

        $response=$this->ticket->setDatepublished($value);

        self::assertInstanceOf(Ticket::class,$response);
        self::assertEquals($value,$this->ticket->getDatepublished());
    }

    public function testGetTicketlot():void{

        $value = new Lot();

        $response=$this->ticket->setTicketlot($value);

        self::assertInstanceOf(Ticket::class,$response);
        self::assertInstanceOf(Lot::class,$this->ticket->getTicketlot());
    }

    public function testgetUser():void{

        $value = new User();

        $response=$this->ticket->setUser($value);

        self::assertInstanceOf(Ticket::class,$response);
        self::assertInstanceOf(User::class,$this->ticket->getUser());
    }
}
