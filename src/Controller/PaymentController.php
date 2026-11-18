<?php

namespace App\Controller;

use App\Entity\Offre;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
    #[Route('/payer/{id}', name: 'app_payment_checkout')]
    public function checkout(Offre $offre, Request $request): Response
    {
        // Utilisation de la clé secrète de test depuis le fichier .env
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        // Récupération dynamique de l'URL publique du Codespace via les en-têtes proxy
        $scheme = $request->headers->get('x-forwarded-proto', $request->getScheme());
        $host = $request->headers->get('x-forwarded-host', $request->getHttpHost());
        $baseUrl = $scheme . '://' . $host;

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $offre->getNom(),
                    ],
                    'unit_amount' => $offre->getPrixMensuel() * 100, // Le montant en centimes
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $baseUrl . $this->generateUrl('payment_success'),
            'cancel_url' => $baseUrl . $this->generateUrl('payment_cancel'),
        ]);

        return $this->redirect($session->url, 303);
    }

    #[Route('/payment/success', name: 'payment_success')]
    public function success(): Response
    {
        return $this->render('payment/success.html.twig');
    }
}