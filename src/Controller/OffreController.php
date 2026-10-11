<?php

namespace App\Controller;


use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OffreController extends AbstractController
{
    #[Route('/offre', name: 'app_offre')]
    public function index(OffreRepository $offreRepository): Response
    {



        return $this->render('offre/index.html.twig', [
            'offre' => $offreRepository->findAll(),
        ]);

    }
}
