<?php

namespace App\Security;

use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class TicketVoter extends Voter{

    const EDIT='EDIT_TICKET';
    const VIEW='VIEW_TICKET';

    protected $attributes=[
        self::EDIT,
        self::VIEW,
    ];

    protected function supports(string $attribute, $subject)
    {
        // return
        //     $attribute === self::EDIT &&
        //     $subject instanceof Ticket;


        if(!in_array($attribute,$this->attributes)){
            return false;
        }
        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            
            return false;

        }

       // return $subject->getUser()->getId() === $user->getId();

            switch($attribute){
                case self::VIEW:
                    return $this->canView($attribute);
                case self::EDIT:
                    return $this->canEdit($token);
                default:
                    return false;
            }
    }

    /**
     * @return bool
     */
    public function canView(string $attribute):bool{

        if(!in_array($attribute,$this->attributes)){
            return false;
        }
        return true;
    }


    /**
     * @return bool
     */
    public function canEdit(TokenInterface $token):bool{
        $userRole=$token->getUser()->getRoles();
        if(!in_array("ROLE_CASHIER",$userRole)){
            return false;
        }
        return true;
    }

}