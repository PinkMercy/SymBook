<?php

namespace App\Controller;

use App\Repository\LivresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LivresController extends AbstractController
{
    #[Route('/livres', name: 'admin_livres')]
    public function index(LivresRepository $rep): Response
    {
        $livres = $rep->findAll();

        return $this->render('livres/table.html.twig', [
            'livres' => $livres,

        ]);
    }

    #[Route('/livres/show/{id}', name: 'admin_livres_show')]
    public function show(LivresRepository $rep, $id): Response
    {
        $livre = $rep->find($id);
        // dd($livre);
        return $this->render('livres/show.html.twig', [
            'livres' => $livre,

        ]);
    }
}
