<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\AtelierRepository;

use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{

    #[Route('/search', name: 'app_search')]

    public function searchAtelier(Request $request, AtelierRepository $atelierRepository): JsonResponse
    {
        $query = $request->query->get('query');
        $ateliers = $atelierRepository->findBySearchTerm($query);

        $results = [];
        foreach ($ateliers as $atelier) {
            $results[] = [
                'id' => $atelier->getId(),
                'Nom' => $atelier->getNom(),
                'adresse' => $atelier->getAdresse(),
                'numero' => $atelier->getNumeroTelephone(),
                'specialite' => $atelier->getSpecialite(),
                'avis' => $atelier->getAvis(),
                'heure_ouverture' => $atelier->getHeureOverture(),
                'heure_fermeture' => $atelier->getHeureFermeture(),
            ];
        }

        return $this->json($results);
    }
}
