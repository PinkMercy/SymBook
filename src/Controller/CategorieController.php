<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/admin/categorie', name: 'admin_categorie')]
    public function index(CategorieRepository $rep): Response
    { $categories=$rep->findAll();
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/admin/categorie/create', name: 'admin_categorie_create')]
    public function create(EntityManagerInterface $em , Request $request): Response
    { $categorie=new Categorie();
        //construction de lobjet form
        $form=$this->createForm(CategorieType::class,$categorie);

        //recuperation et traitement des donnees
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('admin_categorie');
        }
        return $this->render('categorie/create.html.twig', [
        'f' =>$form,
        
            
        ]);
    }

    #[Route('/admin/categorie/update/{id}', name: 'admin_categorie_update')]
    public function update(EntityManagerInterface $em , Request $request , Categorie $categorie): Response
    {   //$categorie=new Categorie();
        //construction de lobjet form
        $form=$this->createForm(CategorieType::class,$categorie);

        //recuperation et traitement des donnees
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $formData=$form->getData();
            dd($formData->getLibelle());
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('admin_categorie');
        }
        return $this->render('categorie/update.html.twig', [
        'f' =>$form,
        
            
        ]);
    }
}
