<?php

namespace App\Controller;

use App\Entity\Crud;
use App\Form\CrudType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $data= $doctrine->getRepository(Crud::class)->findAll();
        return $this->render('main/index.html.twig', [
            'list' => $data,
        ]);
    }
    #[Route('create', name: 'create')]
    public function create(Request $request, ManagerRegistry $doctrine){
        $crud = new Crud();
        $form = $this->createForm(CrudType::class,$crud);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($crud);
            $em->flush();
            $this->addFlash("notice","Submitted Successfully ");
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/create.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/update{id}', name: 'update')]
    public function update(Request $request, ManagerRegistry $doctrine, $id){
        
        $crud = $doctrine->getRepository(Crud::class)->find($id);
        $form = $this->createForm(CrudType::class,$crud);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($crud);
            $em->flush();
            $this->addFlash("notice","Submitted Successfully ");
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/update.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/delete{id}', name: 'delete')]
    public function delete(Request $request, ManagerRegistry $doctrine, $id){
        
        $data = $doctrine->getRepository(Crud::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($data);
        $em->flush();
        $this->addFlash('notice','Successfully deleted');
        return $this->redirectToRoute('app_main');
    }

    
}
