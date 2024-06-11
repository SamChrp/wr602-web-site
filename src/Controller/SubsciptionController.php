<?php

namespace App\Controller;

use App\Repository\SubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubsciptionController extends AbstractController
{
    #[Route('/subsciption', name: 'app_subsciption')]
    public function index
    (
        SubscriptionRepository $subscriptionRepository
    )
    : Response
    {
        $subscriptions = $subscriptionRepository->findAll();

        return $this->render('subsciption/index.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }
}
