<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\AssuranceRepository;


use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{

    #[Route('/search', name: 'app_search')]

    public function searchAssurances(Request $request, AssuranceRepository $assuranceRepository): JsonResponse
    {
        $query = $request->query->get('query');
        $assurances = $assuranceRepository->searchAssurances($query);

        $results = [];
        foreach ($assurances as $assurance) {
            $results[] = [
                'id' => $assurance->getId(),
                'NomAssurance' => $assurance->getNomAssurance(),
                'adresseAssurance' => $assurance->getAdresseAssurance(),
                'codePostalAssurance' => $assurance->getCodePostalAssurance(),
                'telAssurance' => $assurance->getTelAssurance(),
                'emailAssurance' => $assurance->getEmailAssurance(),
            ];
        }

        return $this->json($results);
    }
}
