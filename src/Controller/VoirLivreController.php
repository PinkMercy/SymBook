<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Repository\LivresRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoirLivreController extends AbstractController
{
    #[Route('/voir/livre', name: 'app_voir_livre')]
    public function index(LivresRepository $rep): Response
    {

        $livres = $rep->findAll();
        return $this->render('voir_livre/index.html.twig', [
            'livres' => $livres,

        ]);
    }

    #[Route('/voir/livre/detail/{id<\d+>}', name: 'app_voir_livre_detail')]
    public function voirdetail(Livres $livre): Response
    {

        
        return $this->render('voir_livre/detail.html.twig', [
            'livres' => $livre,

        ]);
    }

    #[Route('/voir/livre/titre', name: 'app_voir_livre_titre')]
    public function search(Request $request, LivresRepository $livrep, CategorieRepository $catrep): Response
    {
        $categories = $catrep->findAll();
        $searchTerm = $request->query->get('search');
    
        if ($searchTerm) {
            $query = $livrep->createQueryBuilder('l')
                ->leftJoin('l.categorie', 'c')
                ->where('l.titre LIKE :titre OR c.libelle LIKE :libelle or l.editeur LIKE :editeur ')
                ->setParameter('titre','%' . $searchTerm . '%' )
                ->setParameter('libelle', '%' . $searchTerm . '%')
                ->setParameter('editeur', '%' . $searchTerm . '%')
                ->getQuery();
    
            $livres = $query->getResult();
        } else {
            // Si aucun terme de recherche n'est spécifié, afficher tous les livres
            $livres = $livrep->findAll();
        }
    
        return $this->render('voir_livre/index.html.twig', [
            'livres' => $livres,
            'categories' => $categories,
        ]);
        }
   
}
