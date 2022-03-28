<?php

namespace App\Controller;
use App\Entity\Signup;
use App\Form\SignupType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
class SignupController extends AbstractController
{
    #[Route('/signup', name: 'signup')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
       $acc = new Signup();
       $form= $this->createForm(SignupType::class,$acc);
       $form->handleRequest($request);
       
       if ($form->isSubmitted() && $form->isValid()){
            
            $em = $doctrine->getManager();
            $em->persist($acc);
            $em->flush();





             
            return $this->redirectToRoute('sign');
     }



       return $this->render('main/signup.html.twig',[
        'form'=>$form->createView()
    ]);
    }


    #[Route('/sign', name: 'sign')]
    public function sign(Request $request, ManagerRegistry $doctrine): Response
    {
     
       return $this->render('main/sign.html.twig');
    }
    public function check(Request $request, ManagerRegistry $doctrine): Response
    {
     
       return $this->render('main/update.html.twig');
    }


}
