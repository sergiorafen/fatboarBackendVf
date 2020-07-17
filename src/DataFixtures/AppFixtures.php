<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture{

    const DEFAULT_USER=['email'=>'rafensergio@gmail.com','password'=>'password'];
    private  $encoder;
    
    public function __construct (UserPasswordEncoderInterface $encoder){
        $this->encoder=$encoder;
    }

    public function load(ObjectManager $manager){
        $fake=Factory::create();

        $defaultUser= new User();
        $passHash=$this->encoder->encodePassword($defaultUser,self::DEFAULT_USER['password']);
        $user->setEmail(self::DEFAULT_USER['email'])->setPassword($passwHash);

        $manager->persist($defaultUser);

        for($u=0;$u<10;$u++){
            $user= new User();
            $passHash=$this->encoder->encodePassword($user,'password');
            $user->setEmail($fake->email)->setPassword($passwHash);

            if($u%3===0){
                $user->setStatus(false)->setAge(25);
            }
            $manager->persist($user);

        }
        
    }

}