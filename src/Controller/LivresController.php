<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivreType;
use Doctrine\ORM\EntityManager;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
class LivresController extends AbstractController
{
    #[Route('/admin/livres', name: 'app_admin_livres')]
    
    public function index(LivresRepository $rep): Response
    {

        //$livres=$rep->findGreaterThan(100);
        //dd($livres);

        $livres = $rep->findAll();
        //dd($livres);
        return $this->render('livres/table.html.twig', [
            'livres' => $livres,

        ]);
    }

    #[Route('/admin/livres/{id<\d+>}', name: 'app_admin_livres_show')]
    public function show(Livres $livre): Response
    {
        //$livre = $rep->find($id);
        //dd($livre);
        //paramConverter
        return $this->render('livres/show.html.twig', [
            'livres' => $livre,

        ]);
    }

    #[Route('/admin/livres/create', name: 'admin_livres_create')]
    public function create(EntityManagerInterface $em): Response
    {
        $livre = new Livres();
        $livre->setImage('https://picsum.photos/300')
            ->setTitre('Titre du livre 10')
            ->setEditeur('Editeur 1')
            ->setISBN('111.1111.1111.1235')
            ->setPrix(200)
            ->setEditedAt(new \DateTimeImmutable('01-01-2024'))
            ->setSlug('titre-du-livre-10')
            ->setResume('hfjhgdkfhfklgfdlkjgjgfmjgfgfjgjgbkjbfl,gj');
        $em->persist($livre);
        $em->flush();
        dd($livre);
        //return $this->render('livres/create.html.twig', [
        //   'livre' => $livre,
        // ]);
        return $this->redirectToRoute('admin_livres');
    }


    #[Route('/admin/livres/add', name: 'admin_livres_add')]
    public function add(EntityManagerInterface $em , Request $request): Response
    { $liv=new Livres();
        //construction de lobjet form
        $form=$this->createForm(LivreType::class,$liv);

        //recuperation et traitement des donnees
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($liv);
            $em->flush();
            return $this->redirectToRoute('app_admin_livres');
        }
        return $this->render('livres/add.html.twig', [
        'f' =>$form,
        ]);
    }


    #[Route('/admin/livres/delete/{id}', name: 'app_admin_livres_delete')]
    public function delete(EntityManagerInterface $em, Livres $livre): Response
    {
        $em->remove($livre);
        $em->flush();
         dd($livre);
        // return $this->redirectToRoute('admin_livres');

    }

    #[Route('/admin/livres/update/{id}', name: 'app_admin_livres_update')]
    public function update(EntityManagerInterface $em, Livres $livre): Response
    {
        $livre->setTitre('Titre du livre 10')
            ->setEditeur('Editeur 1')
            ->setISBN('111.1111.1111.1235')
            ->setPrix(200)
            ->setEditedAt(new \DateTimeImmutable('01-01-2024'))
            ->setSlug('titre-du-livre-10')
            ->setResume('hfjhgdkfhfklgfdlkjgjgfmjgfgfjgjgbkjbfl,gj');
        $em->persist($livre);
        $em->flush();
        dd($livre);
        //return $this->render('livres/create.html.twig', [
        //   'livre' => $livre,
        // ]);
        return $this->redirectToRoute('admin_livres');
    }

   
    


}