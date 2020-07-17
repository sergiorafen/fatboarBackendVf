<?php

namespace App\Controller;

use App\Entity\Ticket;
use Symfony\Component\Security\Core\Security;

class TicketCreateController{

    private $security;

    public function __construct(Security $security){

        $this->security = $security;
        
    }

    public function __invoke(Ticket $data){

        $data->setUser($this->security->getUser());
        return $data;

    }
}