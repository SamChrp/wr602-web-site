<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Entity\User;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/subsciption/user/{subscription}', name: 'app_subsciption_user')]
    public function subsciptionUser
    (
        Subscription $subscription,
        EntityManagerInterface $entityManager
    )
    : Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour vous abonner à une offre.');
            return $this->redirectToRoute('app_subsciption');
        }

        $user->setSubscription($subscription);
        $entityManager->flush();

        return $this->redirectToRoute('app_subsciption');
    }
}
