<?php

namespace App\Controller;

use App\Entity\Baie;
use App\Form\BaieType;
use App\Repository\BaieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/baie')]
final class BaieController extends AbstractController
{
    #[Route(name: 'app_baie_index', methods: ['GET'])]
    public function index(BaieRepository $baieRepository): Response
    {
        return $this->render('baie/index.html.twig', [
            'baies' => $baieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_baie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $baie = new Baie();
        $form = $this->createForm(BaieType::class, $baie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($baie);
            $entityManager->flush();

            return $this->redirectToRoute('app_baie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('baie/new.html.twig', [
            'baie' => $baie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_baie_show', methods: ['GET'])]
    public function show(Baie $baie): Response
    {
        return $this->render('baie/show.html.twig', [
            'baie' => $baie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_baie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Baie $baie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BaieType::class, $baie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_baie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('baie/edit.html.twig', [
            'baie' => $baie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_baie_delete', methods: ['POST'])]
    public function delete(Request $request, Baie $baie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$baie->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($baie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_baie_index', [], Response::HTTP_SEE_OTHER);
    }
}
