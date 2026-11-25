<?php

namespace App\Controller;

use App\Entity\Baie;
use App\Entity\Offre;
use App\Entity\Reservation;
use App\Entity\Status;
use App\Entity\Unite;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/payer/{id}', name: 'app_payment_checkout')]
    public function checkout(
        Offre $offre,
        Request $request,
        #[Autowire('%env(STRIPE_SECRET_KEY)%')] string $stripeSecretKey
    ): Response {
        $period = $request->query->get('period', 'mensuel');
        if (!in_array($period, ['mensuel', 'annuel'], true)) {
            $period = 'mensuel';
        }

        $prix = $period === 'annuel' ? $offre->getPrixAnnuel() : $offre->getPrixMensuel();
        $interval = $period === 'annuel' ? 'year' : 'month';
        $labelPeriod = $period === 'annuel' ? 'Annuel' : 'Mensuel';

        Stripe::setApiKey($stripeSecretKey);

        $scheme = $request->headers->get('x-forwarded-proto', $request->getScheme());
        $host = $request->headers->get('x-forwarded-host', $request->getHttpHost());
        $baseUrl = $scheme . '://' . $host;

        $successUrl = str_replace(
            '%7BCHECKOUT_SESSION_ID%7D',
            '{CHECKOUT_SESSION_ID}',
            $baseUrl . $this->generateUrl('payment_success', [
                'offre_id' => $offre->getId(),
                'period' => $period,
                'session_id' => '{CHECKOUT_SESSION_ID}',
            ])
        );

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => sprintf('%s (%s)', $offre->getNom(), $labelPeriod),
                    ],
                    'unit_amount' => (int) round($prix * 100),
                    'recurring' => [
                        'interval' => $interval,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'metadata' => [
                'offre_id' => $offre->getId(),
                'period' => $period,
            ],
            'success_url' => $successUrl,
            'cancel_url' => $baseUrl . $this->generateUrl('payment_cancel'),
        ]);

        return $this->redirect($session->url, 303);
    }

    #[Route('/payment/success', name: 'payment_success')]
    public function success(
        Request $request,
        EntityManagerInterface $entitymanager,
        #[Autowire('%env(STRIPE_SECRET_KEY)%')] string $stripeSecretKey
    ): Response {
        $offreId = $request->query->get('offre_id');
        $period = $request->query->get('period', 'mensuel');
        if (!in_array($period, ['mensuel', 'annuel'], true)) {
            $period = 'mensuel';
        }
        $user = $this->getUser();

        $sessionId = $request->query->get('session_id');
        $stripeSubscriptionId = null;

        if ($sessionId && $sessionId !== '{CHECKOUT_SESSION_ID}') {
            Stripe::setApiKey($stripeSecretKey);
            $checkoutSession = Session::retrieve($sessionId);
            $stripeSubscriptionId = is_string($checkoutSession->subscription)
                ? $checkoutSession->subscription
                : ($checkoutSession->subscription->id ?? null);
        }

        if ($offreId) {
            $offre = $entitymanager->getRepository(Offre::class)->find($offreId);

            if ($offre && $this->getUser()) {
                $reservation = new Reservation();
                $reservation->setClient($user);
                $reservation->setOffre($offre);
                $reservation->setPeriod($period);
                $reservation->setPaidAt(new \DateTimeImmutable());
                $reservation->setStripeSubscriptionId($stripeSubscriptionId);

                $entitymanager->persist($reservation);

                $nombreTotalUnites = $offre->getNbunit();
                $baieCourante = null;
                $numeroBaie = 1;

                $status = $entitymanager->getRepository(Status::class)->findOneBy(['name' => 'Disponible']);

                for ($i = 1; $i <= $nombreTotalUnites; $i++) {
                    $positionBaie = ($i - 1) % 42;

                    if ($positionBaie === 0) {
                        $baie = new Baie();
                        $baie->setNumero(sprintf('B%03d', $numeroBaie));
                        $baie->setReservation($reservation);
                        $entitymanager->persist($baie);
                        $baieCourante = $baie;
                        $numeroBaie++;
                    }

                    $numeroUnite = $positionBaie + 1;
                    $unite = new Unite();
                    $unite->setNumeroU(sprintf('U%03d', $numeroUnite));
                    $unite->setReservation($reservation);
                    if ($status) {
                        $unite->setStatus($status);
                    }
                    $unite->setBaie($baieCourante);
                    $entitymanager->persist($unite);
                }

                $entitymanager->flush();
            }
        }

        return $this->render('payment/success.html.twig', ['period' => $period]);
    }

    #[Route('/payment/cancel', name: 'payment_cancel')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }
}
