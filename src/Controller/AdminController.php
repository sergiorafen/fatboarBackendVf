<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController{

    public function ManageCashier(Request $request, UserPasswordEncoderInterface $encoder){
        $em = $this->getDoctrine()->getManager();
        $username = $request->request->get('username');
        $email = $request->request->get('email');
        //$nom = $request->request->get('nom');
        $password = $request->request->get('password');
        $cgvcgu=$request->request->get('cgvcgu');
        $newsletter=$request->request->get('newsletter');
        $majeur=$request->request->get('majeur');
        $roles = $request->request->get('role');

        $user = new User();
        if (filter_var($email  , FILTER_VALIDATE_EMAIL)) {
              $user->setEmail($email);
        } else {
            return new Response(sprintf($email.' email invalide'));
        }
        //$user->setNom($nom);
        $user->setUsername($username);
        $user->setCgvcgu($cgvcgu);
        $user->setNewsletter($newsletter);
        $user->setMajeur($majeur);

        $roles[]='ROLE_CASHIER';
        $user->setRoles(array_unique($roles));

        $user->setPassword($encoder->encodePassword($user, $password));
        $em->persist($user);
        $em->flush();

        return new Response(sprintf('Cashier %s successfully created', $user->getEmail()));
    }
}